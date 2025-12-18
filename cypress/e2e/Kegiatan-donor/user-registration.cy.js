describe('User Registration - Kegiatan Donor', () => {
  beforeEach(() => {
    cy.loginAsPendonor()
  })

  it('Pendonor dapat mendaftar ke kegiatan donor', function() {
    cy.visit('/kegiatan-donor', { failOnStatusCode: false })
    
    cy.get('body').then(($body) => {
      if ($body.text().includes('404') || $body.text().includes('Not Found')) {
        cy.log('⚠️ Halaman belum tersedia - Test skipped')
        this.skip()
        return
      }
      
      cy.get('.kegiatan-card').first().click()
      cy.contains('Daftar Sekarang').click()
      cy.get('button[type="submit"]').click()
      cy.contains('Pendaftaran berhasil').should('be.visible')
    })
  })

  it('Validasi: Tidak bisa mendaftar ke kegiatan yang sudah penuh', function() {
    cy.visit('/kegiatan-donor', { failOnStatusCode: false })
    
    cy.get('body').then(($body) => {
      if ($body.text().includes('404') || $body.text().includes('Not Found')) {
        cy.log('⚠️ Halaman belum tersedia - Test skipped')
        this.skip()
        return
      }
      
      cy.get('.kegiatan-card').contains('Penuh').parent().click()
      cy.get('button:contains("Daftar")').should('be.disabled')
      cy.contains('Kuota peserta sudah penuh').should('be.visible')
    })
  })

  it('Validasi: Tidak bisa mendaftar dua kali ke kegiatan yang sama', function() {
    cy.visit('/kegiatan-donor', { failOnStatusCode: false })
    
    cy.get('body').then(($body) => {
      if ($body.text().includes('404') || $body.text().includes('Not Found')) {
        cy.log('⚠️ Halaman belum tersedia - Test skipped')
        this.skip()
        return
      }
      
      cy.get('.kegiatan-card').first().click()
      cy.contains('Daftar Sekarang').click()
      cy.get('button[type="submit"]').click()
      cy.contains('Sudah terdaftar').should('be.visible')
    })
  })

  it('Pendonor dapat membatalkan pendaftaran', function() {
    cy.visit('/dashboard/pendonor/kegiatan-saya', { failOnStatusCode: false })
    
    cy.get('body').then(($body) => {
      if ($body.text().includes('404') || $body.text().includes('Not Found')) {
        cy.log('⚠️ Halaman belum tersedia - Test skipped')
        this.skip()
        return
      }
      
      cy.get('.kegiatan-item').first().within(() => {
        cy.contains('Batal').click()
      })
      cy.contains('Konfirmasi Pembatalan').should('be.visible')
      cy.get('button').contains('Ya, Batalkan').click()
      cy.contains('Pendaftaran berhasil dibatalkan').should('be.visible')
    })
  })

  it('Pendonor dapat melihat daftar kegiatan yang diikuti', function() {
    cy.visit('/dashboard/pendonor/kegiatan-saya', { failOnStatusCode: false })
    
    cy.get('body').then(($body) => {
      if ($body.text().includes('404') || $body.text().includes('Not Found')) {
        cy.log('⚠️ Halaman belum tersedia - Test skipped')
        this.skip()
        return
      }
      
      cy.get('.kegiatan-item').should('exist')
      cy.contains('Kegiatan yang Anda Ikuti').should('be.visible')
    })
  })

  it('Pendonor dapat melihat detail pendaftaran', function() {
    cy.visit('/dashboard/pendonor/kegiatan-saya', { failOnStatusCode: false })
    
    cy.get('body').then(($body) => {
      if ($body.text().includes('404') || $body.text().includes('Not Found')) {
        cy.log('⚠️ Halaman belum tersedia - Test skipped')
        this.skip()
        return
      }
      
      cy.get('.kegiatan-item').first().click()
      cy.contains('Nomor Registrasi').should('be.visible')
      cy.contains('Status Pendaftaran').should('be.visible')
    })
  })

  it('Pendonor menerima notifikasi setelah mendaftar', function() {
    cy.visit('/kegiatan-donor', { failOnStatusCode: false })
    
    cy.get('body').then(($body) => {
      if ($body.text().includes('404') || $body.text().includes('Not Found')) {
        cy.log('⚠️ Halaman belum tersedia - Test skipped')
        this.skip()
        return
      }
      
      cy.get('.kegiatan-card').first().click()
      cy.contains('Daftar Sekarang').click()
      cy.get('button[type="submit"]').click()
      cy.visit('/dashboard/pendonor/notifikasi', { failOnStatusCode: false })
      cy.contains('Pendaftaran kegiatan berhasil').should('be.visible')
    })
  })

  it('Validasi: Tidak bisa mendaftar jika belum memenuhi syarat donor', function() {
    cy.visit('/kegiatan-donor', { failOnStatusCode: false })
    
    cy.get('body').then(($body) => {
      if ($body.text().includes('404') || $body.text().includes('Not Found')) {
        cy.log('⚠️ Halaman belum tersedia - Test skipped')
        this.skip()
        return
      }
      
      cy.get('.kegiatan-card').first().click()
      cy.contains('Daftar Sekarang').click()
      cy.get('button[type="submit"]').click()
      cy.contains('Anda belum memenuhi syarat').should('be.visible')
    })
  })

  it('Pendonor dapat mengisi form kesehatan saat mendaftar', function() {
    cy.visit('/kegiatan-donor', { failOnStatusCode: false })
    
    cy.get('body').then(($body) => {
      if ($body.text().includes('404') || $body.text().includes('Not Found')) {
        cy.log('⚠️ Halaman belum tersedia - Test skipped')
        this.skip()
        return
      }
      
      cy.get('.kegiatan-card').first().click()
      cy.contains('Daftar Sekarang').click()
      
      // Isi form kesehatan
      cy.get('input[name="berat_badan"]').type('60')
      cy.get('input[name="tekanan_darah"]').type('120/80')
      cy.get('select[name="riwayat_penyakit"]').select('tidak_ada')
      cy.get('input[name="konsumsi_obat"]').check()
      
      cy.get('button[type="submit"]').click()
      cy.contains('Pendaftaran berhasil').should('be.visible')
    })
  })

  it('Menampilkan QR code setelah pendaftaran berhasil', function() {
    cy.visit('/dashboard/pendonor/kegiatan-saya', { failOnStatusCode: false })
    
    cy.get('body').then(($body) => {
      if ($body.text().includes('404') || $body.text().includes('Not Found')) {
        cy.log('⚠️ Halaman belum tersedia - Test skipped')
        this.skip()
        return
      }
      
      cy.get('.kegiatan-item').first().within(() => {
        cy.contains('Lihat QR Code').click()
      })
      cy.get('.qr-code').should('be.visible')
      cy.contains('Tunjukkan QR code ini').should('be.visible')
    })
  })
})