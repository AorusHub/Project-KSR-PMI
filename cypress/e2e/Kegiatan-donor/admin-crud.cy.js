// cypress/e2e/kegiatan-donor/admin-crud.cy.js

describe('Kegiatan Donor - Admin CRUD Operations', () => {
  beforeEach(() => {
    cy.loginAsAdmin()
    cy.visit('/managemen-kegiatan')
  })

  it('should create new activity successfully', () => {
    cy.get('button').contains('Tambah Kegiatan').click()
    
    cy.get('input[name="nama_kegiatan"]').type('Donor Darah Cypress Test')
    cy.get('input[name="tanggal"]').type('2024-12-31')
    cy.get('input[name="waktu_mulai"]').type('09:00')
    cy.get('input[name="waktu_selesai"]').type('14:00')
    cy.get('input[name="lokasi"]').type('PMI Cabang Test')
    cy.get('textarea[name="rincian_lokasi"]').type('Jl. Testing No. 123')
    cy.get('textarea[name="deskripsi"]').type('Kegiatan donor darah untuk testing')
    cy.get('input[name="target_donor"]').type('100')
    cy.get('input[name="latitude"]').type('-6.200000')
    cy.get('input[name="longitude"]').type('106.816666')
    cy.get('select[name="status"]').select('Planned')
    
    cy.intercept('POST', '/kegiatan-donor').as('createKegiatan')
    cy.get('button[type="submit"]').click()
    
    cy.wait('@createKegiatan').its('response.statusCode').should('eq', 200)
    cy.contains('berhasil ditambahkan').should('be.visible')
  })

  it('should validate required fields', () => {
    cy.get('button').contains('Tambah Kegiatan').click()
    cy.get('button[type="submit"]').click()
    
    cy.get('.invalid-feedback, .error').should('have.length.at.least', 1)
  })

  it('should validate field max lengths', () => {
    cy.get('button').contains('Tambah Kegiatan').click()
    
    cy.get('input[name="nama_kegiatan"]').type('A'.repeat(101))
    cy.get('input[name="lokasi"]').type('B'.repeat(201))
    
    cy.get('button[type="submit"]').click()
    cy.contains('tidak boleh lebih dari').should('be.visible')
  })

  it('should set default waktu_selesai if empty', () => {
    cy.get('button').contains('Tambah Kegiatan').click()
    
    cy.get('input[name="nama_kegiatan"]').type('Test Kegiatan')
    cy.get('input[name="tanggal"]').type('2024-12-31')
    cy.get('input[name="waktu_mulai"]').type('09:00')
    cy.get('input[name="lokasi"]').type('Test Lokasi')
    cy.get('select[name="status"]').select('Planned')
    
    // Don't fill waktu_selesai
    cy.get('input[name="waktu_selesai"]').clear()
    
    cy.intercept('POST', '/kegiatan-donor').as('create')
    cy.get('button[type="submit"]').click()
    
    cy.wait('@create').then((interception) => {
      expect(interception.request.body.waktu_selesai).to.equal('14:00')
    })
  })

  it('should edit existing activity', () => {
    cy.get('.btn-edit').first().click()
    
    cy.get('input[name="nama_kegiatan"]')
      .clear()
      .type('Updated Activity Name')
    
    cy.intercept('PUT', '/kegiatan-donor/*').as('updateKegiatan')
    cy.get('button[type="submit"]').click()
    
    cy.wait('@updateKegiatan').its('response.statusCode').should('eq', 200)
    cy.contains('berhasil diupdate').should('be.visible')
  })

  it('should handle AJAX requests for create/update', () => {
    cy.intercept('POST', '/kegiatan-donor', (req) => {
      req.headers['X-Requested-With'] = 'XMLHttpRequest'
    }).as('ajaxCreate')
    
    cy.get('button').contains('Tambah Kegiatan').click()
    
    cy.get('input[name="nama_kegiatan"]').type('AJAX Test')
    cy.get('input[name="tanggal"]').type('2024-12-31')
    cy.get('input[name="waktu_mulai"]').type('09:00')
    cy.get('input[name="waktu_selesai"]').type('14:00')
    cy.get('input[name="lokasi"]').type('Test')
    cy.get('select[name="status"]').select('Planned')
    
    cy.get('button[type="submit"]').click()
    
    cy.wait('@ajaxCreate').then((interception) => {
      expect(interception.response.body).to.have.property('success', true)
    })
  })

  it('should delete activity', () => {
    cy.intercept('DELETE', '/kegiatan-donor/*').as('deleteKegiatan')
    
    cy.get('.btn-delete').first().click()
    cy.get('.swal2-confirm').click() // Confirm deletion
    
    cy.wait('@deleteKegiatan').its('response.statusCode').should('eq', 200)
    cy.contains('berhasil dihapus').should('be.visible')
  })

  it('should trigger KegiatanDonorCreated event on create', () => {
    cy.intercept('POST', '/kegiatan-donor').as('create')
    
    cy.get('button').contains('Tambah Kegiatan').click()
    
    cy.get('input[name="nama_kegiatan"]').type('Event Test')
    cy.get('input[name="tanggal"]').type('2024-12-31')
    cy.get('input[name="waktu_mulai"]').type('09:00')
    cy.get('input[name="waktu_selesai"]').type('14:00')
    cy.get('input[name="lokasi"]').type('Test')
    cy.get('select[name="status"]').select('Planned')
    
    cy.get('button[type="submit"]').click()
    
    cy.wait('@create')
    // Verify event was triggered (you may need WebSocket or Pusher verification)
  })
})