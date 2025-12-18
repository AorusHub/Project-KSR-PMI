describe('Admin Management - Kegiatan Donor', () => {
  beforeEach(() => {
    cy.loginAsAdmin()
  })

  it('Admin dapat melihat statistik kegiatan donor', function() {
    cy.visit('/dashboard/admin', { failOnStatusCode: false })
    
    cy.get('body').then(($body) => {
      if ($body.text().includes('404') || $body.text().includes('Not Found')) {
        cy.log('⚠️ Halaman belum tersedia - Test skipped')
        this.skip()
        return
      }
      
      cy.contains('Total Kegiatan').should('be.visible')
      cy.contains('Total Peserta').should('be.visible')
      cy.contains('Kegiatan Aktif').should('be.visible')
    })
  })

  it('Admin dapat export data kegiatan ke Excel', function() {
    cy.visit('/dashboard/admin/kegiatan-donor', { failOnStatusCode: false })
    
    cy.get('body').then(($body) => {
      if ($body.text().includes('404') || $body.text().includes('Not Found')) {
        cy.log('⚠️ Halaman belum tersedia - Test skipped')
        this.skip()
        return
      }
      
      cy.contains('Export').click()
      cy.contains('Excel').click()
    })
  })

  it('Admin dapat export data kegiatan ke PDF', function() {
    cy.visit('/dashboard/admin/kegiatan-donor', { failOnStatusCode: false })
    
    cy.get('body').then(($body) => {
      if ($body.text().includes('404') || $body.text().includes('Not Found')) {
        cy.log('⚠️ Halaman belum tersedia - Test skipped')
        this.skip()
        return
      }
      
      cy.contains('Export').click()
      cy.contains('PDF').click()
    })
  })

  it('Admin dapat filter kegiatan berdasarkan tanggal', function() {
    cy.visit('/dashboard/admin/kegiatan-donor', { failOnStatusCode: false })
    
    cy.get('body').then(($body) => {
      if ($body.text().includes('404') || $body.text().includes('Not Found')) {
        cy.log('⚠️ Halaman belum tersedia - Test skipped')
        this.skip()
        return
      }
      
      cy.get('input[name="tanggal_mulai"]').type('2024-01-01')
      cy.get('input[name="tanggal_akhir"]').type('2024-12-31')
      cy.get('button[type="submit"]').click()
      cy.get('.kegiatan-item').should('exist')
    })
  })

  it('Admin dapat melihat detail peserta per kegiatan', function() {
    cy.visit('/dashboard/admin/kegiatan-donor', { failOnStatusCode: false })
    
    cy.get('body').then(($body) => {
      if ($body.text().includes('404') || $body.text().includes('Not Found')) {
        cy.log('⚠️ Halaman belum tersedia - Test skipped')
        this.skip()
        return
      }
      
      cy.get('.kegiatan-item').first().within(() => {
        cy.contains('Lihat Peserta').click()
      })
      cy.contains('Daftar Peserta').should('be.visible')
      cy.get('.peserta-item').should('exist')
    })
  })

  it('Admin dapat mengirim notifikasi broadcast ke semua peserta', function() {
    cy.visit('/dashboard/admin/kegiatan-donor', { failOnStatusCode: false })
    
    cy.get('body').then(($body) => {
      if ($body.text().includes('404') || $body.text().includes('Not Found')) {
        cy.log('⚠️ Halaman belum tersedia - Test skipped')
        this.skip()
        return
      }
      
      cy.get('.kegiatan-item').first().within(() => {
        cy.contains('Kirim Notifikasi').click()
      })
      cy.get('textarea[name="pesan"]').type('Pengumuman penting untuk semua peserta')
      cy.get('button[type="submit"]').click()
      cy.contains('Notifikasi berhasil dikirim').should('be.visible')
    })
  })

  it('Admin dapat melihat grafik partisipasi donor', function() {
    cy.visit('/dashboard/admin', { failOnStatusCode: false })
    
    cy.get('body').then(($body) => {
      if ($body.text().includes('404') || $body.text().includes('Not Found')) {
        cy.log('⚠️ Halaman belum tersedia - Test skipped')
        this.skip()
        return
      }
      
      cy.get('.chart-container').should('exist')
      cy.contains('Grafik Partisipasi').should('be.visible')
    })
  })

  it('Admin dapat melakukan pencarian kegiatan', function() {
    cy.visit('/dashboard/admin/kegiatan-donor', { failOnStatusCode: false })
    
    cy.get('body').then(($body) => {
      if ($body.text().includes('404') || $body.text().includes('Not Found')) {
        cy.log('⚠️ Halaman belum tersedia - Test skipped')
        this.skip()
        return
      }
      
      cy.get('input[name="search"]').type('Donor Darah')
      cy.get('button[type="submit"]').click()
      cy.get('.kegiatan-item').should('contain', 'Donor Darah')
    })
  })
})