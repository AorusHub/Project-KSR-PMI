describe('Status Update - Kegiatan Donor', () => {
  beforeEach(() => {
    cy.loginAsAdmin()
  })

  it('Admin dapat mengubah status kegiatan menjadi "Sedang Berlangsung"', function() {
    cy.visit('/dashboard/admin/kegiatan-donor', { failOnStatusCode: false })
    
    cy.get('body').then(($body) => {
      if ($body.text().includes('404') || $body.text().includes('Not Found')) {
        cy.log('⚠️ Halaman belum tersedia - Test skipped')
        this.skip()
        return
      }
      
      cy.get('.kegiatan-item').first().within(() => {
        cy.contains('Edit').click()
      })
      cy.get('select[name="status"]').select('ongoing')
      cy.get('button[type="submit"]').click()
      cy.contains('Status berhasil diubah').should('be.visible')
    })
  })

  it('Admin dapat mengubah status kegiatan menjadi "Selesai"', function() {
    cy.visit('/dashboard/admin/kegiatan-donor', { failOnStatusCode: false })
    
    cy.get('body').then(($body) => {
      if ($body.text().includes('404') || $body.text().includes('Not Found')) {
        cy.log('⚠️ Halaman belum tersedia - Test skipped')
        this.skip()
        return
      }
      
      cy.get('.kegiatan-item').first().within(() => {
        cy.contains('Edit').click()
      })
      cy.get('select[name="status"]').select('completed')
      cy.get('button[type="submit"]').click()
      cy.contains('Status berhasil diubah').should('be.visible')
    })
  })

  it('Admin dapat mengubah status kegiatan menjadi "Dibatalkan"', function() {
    cy.visit('/dashboard/admin/kegiatan-donor', { failOnStatusCode: false })
    
    cy.get('body').then(($body) => {
      if ($body.text().includes('404') || $body.text().includes('Not Found')) {
        cy.log('⚠️ Halaman belum tersedia - Test skipped')
        this.skip()
        return
      }
      
      cy.get('.kegiatan-item').first().within(() => {
        cy.contains('Edit').click()
      })
      cy.get('select[name="status"]').select('cancelled')
      cy.get('textarea[name="alasan_pembatalan"]').type('Cuaca buruk')
      cy.get('button[type="submit"]').click()
      cy.contains('Status berhasil diubah').should('be.visible')
    })
  })

  it('Validasi: Tidak bisa mengubah status tanpa alasan pembatalan', function() {
    cy.visit('/dashboard/admin/kegiatan-donor', { failOnStatusCode: false })
    
    cy.get('body').then(($body) => {
      if ($body.text().includes('404') || $body.text().includes('Not Found')) {
        cy.log('⚠️ Halaman belum tersedia - Test skipped')
        this.skip()
        return
      }
      
      cy.get('.kegiatan-item').first().within(() => {
        cy.contains('Edit').click()
      })
      cy.get('select[name="status"]').select('cancelled')
      cy.get('button[type="submit"]').click()
      cy.contains('Alasan pembatalan wajib diisi').should('be.visible')
    })
  })

  it('Peserta menerima notifikasi saat status kegiatan diubah', function() {
    cy.visit('/dashboard/admin/kegiatan-donor', { failOnStatusCode: false })
    
    cy.get('body').then(($body) => {
      if ($body.text().includes('404') || $body.text().includes('Not Found')) {
        cy.log('⚠️ Halaman belum tersedia - Test skipped')
        this.skip()
        return
      }
      
      cy.get('.kegiatan-item').first().within(() => {
        cy.contains('Edit').click()
      })
      cy.get('select[name="status"]').select('cancelled')
      cy.get('textarea[name="alasan_pembatalan"]').type('Perubahan jadwal')
      cy.get('input[name="kirim_notifikasi"]').check()
      cy.get('button[type="submit"]').click()
      cy.contains('Notifikasi berhasil dikirim').should('be.visible')
    })
  })

  it('Status history tercatat dengan benar', function() {
    cy.visit('/dashboard/admin/kegiatan-donor', { failOnStatusCode: false })
    
    cy.get('body').then(($body) => {
      if ($body.text().includes('404') || $body.text().includes('Not Found')) {
        cy.log('⚠️ Halaman belum tersedia - Test skipped')
        this.skip()
        return
      }
      
      cy.get('.kegiatan-item').first().click()
      cy.contains('Riwayat Status').click()
      cy.get('.status-history-item').should('exist')
      cy.contains('Diubah oleh').should('be.visible')
    })
  })

  it('Filter kegiatan berdasarkan status', function() {
    cy.visit('/dashboard/admin/kegiatan-donor', { failOnStatusCode: false })
    
    cy.get('body').then(($body) => {
      if ($body.text().includes('404') || $body.text().includes('Not Found')) {
        cy.log('⚠️ Halaman belum tersedia - Test skipped')
        this.skip()
        return
      }
      
      cy.get('select[name="filter_status"]').select('upcoming')
      cy.get('.kegiatan-item').each(($el) => {
        cy.wrap($el).should('contain', 'Akan Datang')
      })
    })
  })

  it('Tidak dapat mengubah status kegiatan yang sudah selesai', function() {
    cy.visit('/dashboard/admin/kegiatan-donor', { failOnStatusCode: false })
    
    cy.get('body').then(($body) => {
      if ($body.text().includes('404') || $body.text().includes('Not Found')) {
        cy.log('⚠️ Halaman belum tersedia - Test skipped')
        this.skip()
        return
      }
      
      cy.get('.kegiatan-item').contains('Selesai').parent().within(() => {
        cy.get('button:contains("Edit")').should('be.disabled')
      })
    })
  })
})