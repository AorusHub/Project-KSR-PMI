describe('Admin - Update Kegiatan Donor', () => {
  beforeEach(() => {
    cy.loginAsAdmin()
    cy.visit('/dashboard/admin/kegiatan-donor', { failOnStatusCode: false })
  })

  it('Admin dapat mengakses halaman edit kegiatan', () => {
    cy.get('body').then(($body) => {
      if ($body.find('a:contains("Edit"), button:contains("Edit")').length > 0) {
        cy.get('a, button').contains(/edit|ubah/i).first().click()
        cy.url().should('include', '/edit')
        cy.checkPageExists()
      }
    })
  })

  it('Form edit menampilkan data yang sudah ada', () => {
    cy.get('body').then(($body) => {
      if ($body.find('a:contains("Edit")').length > 0) {
        cy.get('a, button').contains(/edit/i).first().click()
        
        cy.get('input[name="nama_kegiatan"]').should('not.have.value', '')
        cy.get('input[name="tanggal"]').should('not.have.value', '')
        cy.get('input[name="lokasi"]').should('not.have.value', '')
        cy.get('input[name="kuota"]').should('not.have.value', '')
      }
    })
  })

  it('Admin dapat mengupdate kegiatan donor', () => {
    cy.get('body').then(($body) => {
      if ($body.find('a:contains("Edit")').length > 0) {
        cy.get('a, button').contains(/edit/i).first().click()
        
        cy.fixture('kegiatan-donor').then((data) => {
          cy.get('input[name="nama_kegiatan"]').clear().type(data.updated.nama)
          cy.get('textarea[name="deskripsi"]').clear().type(data.updated.deskripsi)
          cy.get('input[name="kuota"]').clear().type(data.updated.kuota)
          
          cy.get('button[type="submit"]').click()
          
          cy.url().should('include', '/kegiatan-donor')
          cy.contains(/berhasil|success|updated/i, { timeout: 10000 }).should('be.visible')
          cy.contains(data.updated.nama).should('be.visible')
        })
      }
    })
  })

  it('Dapat membatalkan update', () => {
    cy.get('body').then(($body) => {
      if ($body.find('a:contains("Edit")').length > 0) {
        cy.get('a, button').contains(/edit/i).first().click()
        
        cy.get('input[name="nama_kegiatan"]').clear().type('Data yang akan dibatalkan')
        cy.get('a, button').contains(/batal|cancel|kembali/i).click()
        
        cy.url().should('include', '/kegiatan-donor')
        cy.contains('Data yang akan dibatalkan').should('not.exist')
      }
    })
  })

  it('Validasi tetap berjalan saat update', () => {
    cy.get('body').then(($body) => {
      if ($body.find('a:contains("Edit")').length > 0) {
        cy.get('a, button').contains(/edit/i).first().click()
        
        cy.get('input[name="nama_kegiatan"]').clear()
        cy.get('button[type="submit"]').click()
        
        cy.contains(/wajib|required/i).should('be.visible')
      }
    })
  })

  it('Tidak dapat update dengan tanggal masa lalu', () => {
    cy.get('body').then(($body) => {
      if ($body.find('a:contains("Edit")').length > 0) {
        cy.get('a, button').contains(/edit/i).first().click()
        
        cy.get('input[name="tanggal"]').clear().type('2020-01-01')
        cy.get('button[type="submit"]').click()
        
        cy.contains(/tanggal.*tidak valid|masa lalu/i).should('be.visible')
      }
    })
  })
})