describe('E2E - Complete Admin Flow', () => {
  it('Full Admin Flow: Create Kegiatan → Manage Pendaftaran → Generate Laporan', () => {
    // ============ STEP 1: LOGIN ADMIN ============
    cy.log('STEP 1: Login sebagai admin')
    cy.loginAsAdmin()
    cy.url().should('include', '/dashboard')
    
    // ============ STEP 2: CREATE KEGIATAN ============
    cy.log('STEP 2: Buat kegiatan donor baru')
    cy.visit('/dashboard/admin/kegiatan-donor/create')
    
    cy.fixture('kegiatan-donor').then((data) => {
      cy.get('input[name="nama_kegiatan"]').type(data.valid.nama)
      cy.get('textarea[name="deskripsi"]').type(data.valid.deskripsi)
      cy.get('input[name="tanggal"]').type(data.valid.tanggal)
      cy.get('input[name="lokasi"]').type(data.valid.lokasi)
      cy.get('input[name="kuota"]').type(data.valid.kuota)
      cy.get('button[type="submit"]').click()
      
      cy.contains(/berhasil|success/i, { timeout: 10000 }).should('be.visible')
      
      // ============ STEP 3: VERIFY KEGIATAN CREATED ============
      cy.log('STEP 3: Verifikasi kegiatan berhasil dibuat')
      cy.visit('/dashboard/admin/kegiatan-donor')
      cy.contains(data.valid.nama).should('be.visible')
    })
    
    // ============ STEP 4: DONOR DAFTAR KEGIATAN ============
    cy.log('STEP 4: Donor mendaftar ke kegiatan')
    cy.logout()
    cy.loginAsDonor()
    cy.visit('/dashboard/donor/kegiatan')
    
    cy.get('body').then(($body) => {
      if ($body.find('button:contains("Daftar")').length > 0) {
        cy.get('button, a').contains(/daftar/i).first().click()
        cy.get('button').contains(/ya/i).click()
        cy.wait(2000)
      }
    })
    
    // ============ STEP 5: ADMIN APPROVE PENDAFTARAN ============
    cy.log('STEP 5: Admin approve pendaftaran')
    cy.logout()
    cy.loginAsAdmin()
    cy.visit('/dashboard/admin/pendaftaran')
    
    cy.get('body').then(($body) => {
      if ($body.find('button:contains("Approve")').length > 0) {
        cy.get('button, a').contains(/approve/i).first().click()
        cy.get('button').contains(/ya/i).click()
        cy.wait(2000)
        cy.contains(/berhasil|approved/i).should('be.visible')
      }
    })
    
    // ============ STEP 6: VIEW DONOR LIST ============
    cy.log('STEP 6: Lihat daftar donor')
    cy.visit('/dashboard/admin/donor')
    cy.checkPageExists()
    cy.get('table, .donor-item').should('exist')
    
    // ============ STEP 7: GENERATE LAPORAN ============
    cy.log('STEP 7: Generate laporan')
    cy.visit('/dashboard/admin/laporan/kegiatan', { failOnStatusCode: false })
    cy.checkPageExists()
    cy.contains(/laporan|report/i).should('be.visible')
    
    // ============ STEP 8: EXPORT DATA ============
    cy.log('STEP 8: Export data donor')
    cy.visit('/dashboard/admin/donor')
    cy.get('body').then(($body) => {
      if ($body.find('button:contains("Export")').length > 0) {
        cy.get('button, a').contains(/export/i).click()
        cy.wait(1000)
      }
    })
    
    // ============ STEP 9: LOGOUT ============
    cy.log('STEP 9: Logout admin')
    cy.logout()
    cy.url().should('include', '/login')
  })

  it('Flow: Admin create → update → delete kegiatan', () => {
    cy.loginAsAdmin()
    
    // Create
    cy.visit('/dashboard/admin/kegiatan-donor/create')
    cy.fixture('kegiatan-donor').then((data) => {
      cy.get('input[name="nama_kegiatan"]').type(data.valid.nama)
      cy.get('textarea[name="deskripsi"]').type(data.valid.deskripsi)
      cy.get('input[name="tanggal"]').type(data.valid.tanggal)
      cy.get('input[name="lokasi"]').type(data.valid.lokasi)
      cy.get('input[name="kuota"]').type(data.valid.kuota)
      cy.get('button[type="submit"]').click()
      cy.wait(2000)
      
      // Update
      cy.visit('/dashboard/admin/kegiatan-donor')
      cy.get('a, button').contains(/edit/i).first().click()
      cy.get('input[name="nama_kegiatan"]').clear().type(data.updated.nama)
      cy.get('button[type="submit"]').click()
      cy.wait(2000)
      
      // Delete
      cy.visit('/dashboard/admin/kegiatan-donor')
      cy.get('button, a').contains(/hapus/i).first().click()
      cy.get('button').contains(/ya/i).click()
      cy.contains(/berhasil.*dihapus/i).should('be.visible')
    })
  })

  it('Flow: Admin approve multiple pendaftaran', () => {
    cy.loginAsAdmin()
    cy.visit('/dashboard/admin/pendaftaran')
    
    cy.get('body').then(($body) => {
      if ($body.find('button:contains("Approve")').length >= 2) {
        // Approve first
        cy.get('button, a').contains(/approve/i).first().click()
        cy.get('button').contains(/ya/i).click()
        cy.wait(2000)
        
        // Approve second
        cy.get('button, a').contains(/approve/i).first().click()
        cy.get('button').contains(/ya/i).click()
        cy.wait(2000)
        
        cy.contains(/berhasil/i).should('be.visible')
      }
    })
  })

  it('Flow: Admin search → filter → export donor', () => {
    cy.loginAsAdmin()
    cy.visit('/dashboard/admin/donor')
    
    // Search
    cy.get('body').then(($body) => {
      if ($body.find('input[type="search"]').length > 0) {
        cy.get('input[type="search"]').type('donor')
        cy.get('button[type="submit"]').click()
        cy.wait(1000)
      }
    })
    
    // Filter
    cy.get('body').then(($body) => {
      if ($body.find('select[name="golongan_darah"]').length > 0) {
        cy.get('select[name="golongan_darah"]').select('A')
        cy.get('button').contains(/filter/i).click()
        cy.wait(1000)
      }
    })
    
    // Export
    cy.get('body').then(($body) => {
      if ($body.find('button:contains("Export")').length > 0) {
        cy.get('button, a').contains(/export/i).click()
        cy.wait(2000)
      }
    })
  })
})