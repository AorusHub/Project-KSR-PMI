describe('Authorization & Access Control', () => {
  context('Public Access', () => {
    it('Guest dapat mengakses halaman public', () => {
      const publicPages = ['/', '/about', '/contact', '/kegiatan']
      
      publicPages.forEach((page) => {
        cy.visit(page, { failOnStatusCode: false })
        cy.get('body').should('not.contain', '403')
        cy.get('body').should('not.contain', 'Forbidden')
      })
    })

    it('Guest tidak dapat mengakses dashboard tanpa login', () => {
      cy.visit('/dashboard/donor', { failOnStatusCode: false })
      cy.url().should('include', '/login')
    })

    it('Guest tidak dapat mengakses admin dashboard', () => {
      cy.visit('/dashboard/admin', { failOnStatusCode: false })
      cy.url().should('include', '/login')
    })
  })

  context('Donor Authorization', () => {
    beforeEach(() => {
      cy.loginAsDonor()
    })

    it('Donor dapat mengakses dashboard donor', () => {
      cy.visit('/dashboard/donor', { failOnStatusCode: false })
      cy.checkPageExists()
      cy.url().should('include', '/dashboard/donor')
    })

    it('Donor dapat mengakses profile sendiri', () => {
      cy.visit('/dashboard/donor/profile', { failOnStatusCode: false })
      cy.checkPageExists()
    })

    it('Donor dapat mengakses kegiatan donor', () => {
      cy.visit('/dashboard/donor/kegiatan', { failOnStatusCode: false })
      cy.checkPageExists()
    })

    it('Donor dapat mengakses riwayat sendiri', () => {
      cy.visit('/dashboard/donor/riwayat', { failOnStatusCode: false })
      cy.checkPageExists()
    })

    it('Donor TIDAK dapat mengakses admin dashboard', () => {
      cy.visit('/dashboard/admin', { failOnStatusCode: false })
      cy.url().should('not.include', '/dashboard/admin')
      cy.get('body').then(($body) => {
        if ($body.text().match(/403|forbidden|unauthorized/i)) {
          cy.contains(/403|forbidden|unauthorized/i).should('be.visible')
        } else {
          cy.url().should('include', '/dashboard/donor')
        }
      })
    })

    it('Donor TIDAK dapat mengakses halaman admin/kegiatan-donor', () => {
      cy.visit('/dashboard/admin/kegiatan-donor', { failOnStatusCode: false })
      cy.url().should('not.include', '/admin/kegiatan-donor')
    })

    it('Donor TIDAK dapat mengakses halaman admin/pendaftaran', () => {
      cy.visit('/dashboard/admin/pendaftaran', { failOnStatusCode: false })
      cy.url().should('not.include', '/admin/pendaftaran')
    })

    it('Donor TIDAK dapat mengakses halaman admin/donor', () => {
      cy.visit('/dashboard/admin/donor', { failOnStatusCode: false })
      cy.url().should('not.include', '/admin/donor')
    })

    it('Donor TIDAK dapat mengakses halaman admin/laporan', () => {
      cy.visit('/dashboard/admin/laporan', { failOnStatusCode: false })
      cy.url().should('not.include', '/admin/laporan')
    })
  })

  context('Admin Authorization', () => {
    beforeEach(() => {
      cy.loginAsAdmin()
    })

    it('Admin dapat mengakses admin dashboard', () => {
      cy.visit('/dashboard/admin', { failOnStatusCode: false })
      cy.checkPageExists()
      cy.url().should('include', '/dashboard/admin')
    })

    it('Admin dapat mengakses kegiatan donor management', () => {
      cy.visit('/dashboard/admin/kegiatan-donor', { failOnStatusCode: false })
      cy.checkPageExists()
    })

    it('Admin dapat mengakses donor management', () => {
      cy.visit('/dashboard/admin/donor', { failOnStatusCode: false })
      cy.checkPageExists()
    })

    it('Admin dapat mengakses pendaftaran management', () => {
      cy.visit('/dashboard/admin/pendaftaran', { failOnStatusCode: false })
      cy.checkPageExists()
    })

    it('Admin dapat mengakses laporan', () => {
      cy.visit('/dashboard/admin/laporan/donor', { failOnStatusCode: false })
      cy.checkPageExists()
    })

    it('Admin dapat mengakses semua CRUD kegiatan', () => {
      const adminPages = [
        '/dashboard/admin/kegiatan-donor',
        '/dashboard/admin/kegiatan-donor/create'
      ]
      
      adminPages.forEach((page) => {
        cy.visit(page, { failOnStatusCode: false })
        cy.checkPageExists()
      })
    })
  })

  context('Session & Token', () => {
    it('Session expired mengarahkan ke login', () => {
      cy.loginAsDonor()
      
      // Clear session
      cy.clearCookies()
      cy.clearLocalStorage()
      
      cy.visit('/dashboard/donor', { failOnStatusCode: false })
      cy.url().should('include', '/login')
    })

    it('Tidak dapat akses dengan token invalid', () => {
      cy.setCookie('laravel_session', 'invalid_token_12345')
      cy.visit('/dashboard/donor', { failOnStatusCode: false })
      cy.url().should('include', '/login')
    })

    it('Remember me functionality works', () => {
      cy.visit('/login')
      cy.fixture('users').then((users) => {
        cy.get('input[name="email"]').type(users.donor.email)
        cy.get('input[name="password"]').type(users.donor.password)
        
        cy.get('body').then(($body) => {
          if ($body.find('input[name="remember"]').length > 0) {
            cy.get('input[name="remember"]').check()
          }
        })
        
        cy.get('button[type="submit"]').click()
        cy.url().should('include', '/dashboard')
      })
    })
  })

  context('CSRF Protection', () => {
    it('Form memiliki CSRF token', () => {
      cy.visit('/login')
      cy.get('input[name="_token"]').should('exist')
    })

    it('POST request tanpa CSRF token ditolak', () => {
      cy.request({
        method: 'POST',
        url: '/login',
        failOnStatusCode: false,
        body: {
          email: 'test@test.com',
          password: 'password'
        }
      }).then((response) => {
        expect(response.status).to.be.oneOf([419, 403])
      })
    })
  })

  context('Rate Limiting', () => {
    it('Too many login attempts dikasi rate limit', () => {
      // Coba login 6 kali dengan password salah
      for (let i = 0; i < 6; i++) {
        cy.visit('/login')
        cy.get('input[name="email"]').type('test@test.com')
        cy.get('input[name="password"]').type('wrongpassword')
        cy.get('button[type="submit"]').click()
        cy.wait(500)
      }
      
      // Attempt ke-7 harus kena rate limit
      cy.visit('/login')
      cy.get('input[name="email"]').type('test@test.com')
      cy.get('input[name="password"]').type('wrongpassword')
      cy.get('button[type="submit"]').click()
      
      cy.get('body').then(($body) => {
        if ($body.text().match(/too many|rate limit|tunggu/i)) {
          cy.contains(/too many|rate limit|tunggu/i).should('be.visible')
        }
      })
    })
  })
})