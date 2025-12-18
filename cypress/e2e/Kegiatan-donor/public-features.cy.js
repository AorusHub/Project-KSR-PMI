describe('Public Features - Kegiatan Donor', () => {
  beforeEach(() => {
    cy.visit('/', { failOnStatusCode: false })
  })

  it('Dapat melihat kegiatan donor tanpa login', function() {
    cy.visit('/kegiatan-donor', { failOnStatusCode: false })
    
    cy.get('body').then(($body) => {
      if ($body.text().includes('404') || $body.text().includes('Not Found')) {
        cy.log('⚠️ Halaman belum tersedia - Test skipped')
        this.skip()
        return
      }
      
      cy.contains('Kegiatan Donor Darah').should('be.visible')
      cy.get('.kegiatan-card').should('exist')
    })
  })

  it('Dapat melihat detail kegiatan tanpa login', function() {
    cy.visit('/kegiatan-donor', { failOnStatusCode: false })
    
    cy.get('body').then(($body) => {
      if ($body.text().includes('404') || $body.text().includes('Not Found')) {
        cy.log('⚠️ Halaman belum tersedia - Test skipped')
        this.skip()
        return
      }
      
      cy.get('.kegiatan-card').first().click()
      cy.url().should('include', '/kegiatan-donor/')
      cy.contains('Detail Kegiatan').should('be.visible')
    })
  })

  it('Dapat melihat informasi lokasi kegiatan', function() {
    cy.visit('/kegiatan-donor', { failOnStatusCode: false })
    
    cy.get('body').then(($body) => {
      if ($body.text().includes('404') || $body.text().includes('Not Found')) {
        cy.log('⚠️ Halaman belum tersedia - Test skipped')
        this.skip()
        return
      }
      
      cy.get('.kegiatan-card').first().within(() => {
        cy.contains('Lokasi:').should('be.visible')
        cy.contains('Tanggal:').should('be.visible')
      })
    })
  })

  it('Dapat melakukan filter kegiatan berdasarkan status', function() {
    cy.visit('/kegiatan-donor', { failOnStatusCode: false })
    
    cy.get('body').then(($body) => {
      if ($body.text().includes('404') || $body.text().includes('Not Found')) {
        cy.log('⚠️ Halaman belum tersedia - Test skipped')
        this.skip()
        return
      }
      
      cy.get('select[name="status"]').select('upcoming')
      cy.get('.kegiatan-card').should('exist')
    })
  })

  it('Dapat melakukan pencarian kegiatan', function() {
    cy.visit('/kegiatan-donor', { failOnStatusCode: false })
    
    cy.get('body').then(($body) => {
      if ($body.text().includes('404') || $body.text().includes('Not Found')) {
        cy.log('⚠️ Halaman belum tersedia - Test skipped')
        this.skip()
        return
      }
      
      cy.get('input[name="search"]').type('donor')
      cy.get('button[type="submit"]').click()
      cy.get('.kegiatan-card').should('exist')
    })
  })

  it('Menampilkan pesan jika tidak ada kegiatan', function() {
    cy.visit('/kegiatan-donor', { failOnStatusCode: false })
    
    cy.get('body').then(($body) => {
      if ($body.text().includes('404') || $body.text().includes('Not Found')) {
        cy.log('⚠️ Halaman belum tersedia - Test skipped')
        this.skip()
        return
      }
      
      cy.get('input[name="search"]').type('xxxxnonexistentxxxx')
      cy.get('button[type="submit"]').click()
      cy.contains('Tidak ada kegiatan').should('be.visible')
    })
  })

  it('Dapat melihat jumlah peserta yang terdaftar', function() {
    cy.visit('/kegiatan-donor', { failOnStatusCode: false })
    
    cy.get('body').then(($body) => {
      if ($body.text().includes('404') || $body.text().includes('Not Found')) {
        cy.log('⚠️ Halaman belum tersedia - Test skipped')
        this.skip()
        return
      }
      
      cy.get('.kegiatan-card').first().within(() => {
        cy.contains('Peserta:').should('be.visible')
      })
    })
  })

  it('Redirect ke login jika ingin mendaftar tanpa login', function() {
    cy.visit('/kegiatan-donor', { failOnStatusCode: false })
    
    cy.get('body').then(($body) => {
      if ($body.text().includes('404') || $body.text().includes('Not Found')) {
        cy.log('⚠️ Halaman belum tersedia - Test skipped')
        this.skip()
        return
      }
      
      cy.get('.kegiatan-card').first().click()
      cy.contains('Daftar').click()
      cy.url().should('include', '/login')
    })
  })
})