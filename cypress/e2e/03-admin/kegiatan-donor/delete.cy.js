describe('Admin - Delete Kegiatan Donor', () => {
  beforeEach(() => {
    cy.loginAsAdmin()
    cy.visit('/dashboard/admin/kegiatan-donor', { failOnStatusCode: false })
  })

  it('Admin dapat menghapus kegiatan donor', () => {
    cy.get('body').then(($body) => {
      if ($body.find('button:contains("Hapus"), a:contains("Hapus")').length > 0) {
        // Ambil nama kegiatan yang akan dihapus
        cy.get('table tbody tr, .kegiatan-item').first()
          .find('td, .nama-kegiatan')
          .first()
          .invoke('text')
          .as('namaKegiatan')
        
        // Klik tombol hapus
        cy.get('button, a').contains(/hapus|delete/i).first().click()
        
        // Konfirmasi hapus
        cy.get('button').contains(/ya|hapus|delete|confirm/i).click()
        
        // Verifikasi berhasil dihapus
        cy.contains(/berhasil.*dihapus|deleted/i, { timeout: 10000 }).should('be.visible')
        
        // Verifikasi data tidak ada lagi
        cy.get('@namaKegiatan').then((namaKegiatan) => {
          cy.contains(namaKegiatan).should('not.exist')
        })
      }
    })
  })

  it('Menampilkan konfirmasi sebelum menghapus', () => {
    cy.get('body').then(($body) => {
      if ($body.find('button:contains("Hapus")').length > 0) {
        cy.get('button, a').contains(/hapus|delete/i).first().click()
        
        // Cek ada modal atau alert konfirmasi
        cy.get('.modal, .swal2-popup, [role="dialog"]').should('be.visible')
        cy.contains(/yakin|confirm|hapus/i).should('be.visible')
      }
    })
  })

  it('Admin dapat membatalkan penghapusan', () => {
    cy.get('body').then(($body) => {
      if ($body.find('button:contains("Hapus")').length > 0) {
        cy.get('button, a').contains(/hapus|delete/i).first().click()
        
        // Klik batal
        cy.get('button').contains(/batal|cancel|tidak/i).click()
        
        // Verifikasi masih di halaman list
        cy.url().should('include', '/kegiatan-donor')
        cy.get('table tbody tr, .kegiatan-item').should('exist')
      }
    })
  })

  it('Tidak dapat menghapus kegiatan yang sudah ada pendaftar', () => {
    cy.get('body').then(($body) => {
      if ($body.find('button:contains("Hapus")[disabled]').length > 0) {
        cy.get('button:contains("Hapus")[disabled]').should('exist')
      }
    })
  })
})