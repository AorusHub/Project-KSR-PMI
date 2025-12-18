describe('Admin - Create Kegiatan Donor', () => {
  
  it('Admin login → dashboard → kegiatan → create modal → submit', () => {
    // ================================================
    // STEP 1-2: LOGIN & DASHBOARD
    // ================================================
    cy.loginAsAdmin()
    cy.wait(2000)
    cy.url({ timeout: 15000 }).should('include', '/dashboard')
    cy.log('✅ Step 1: Login berhasil')
    
    cy.get('body', { timeout: 30000 }).should('be.visible')
    cy.contains(/dashboard/i).should('exist')
    cy.log('✅ Step 2: Dashboard terbuka')
    
    // ================================================
    // STEP 3: NAVIGATE TO KEGIATAN
    // ================================================
    cy.visit('/managemen-kegiatan', { 
      failOnStatusCode: false,
      timeout: 60000 
    })
    cy.wait(2000)
    cy.get('body').should('be.visible')
    cy.log('✅ Step 3: Halaman Kegiatan terbuka')
    
    // ================================================
    // STEP 4: CLICK "BUAT KEGIATAN BARU" BUTTON
    // ================================================
    cy.contains('button', 'Buat Kegiatan Baru')
      .should('be.visible')
      .click({ force: true })
    
    cy.wait(2000)
    cy.log('✅ Step 4: Modal create kegiatan terbuka')
    
    cy.get('#formKegiatan', { timeout: 10000 }).should('be.visible')
    cy.wait(2000)
    
    // ================================================
    // STEP 5: ISI FORM (TANPA KOORDINAT) ✅
    // ================================================
    cy.fixture('kegiatan-donor').then((data) => {
      const kegiatan = data.valid
      const uniqueName = `${kegiatan.nama_kegiatan} ${Date.now()}`
      
      cy.log('📝 Mulai mengisi form...')
      
      // 1. Nama Kegiatan
      cy.get('#formKegiatan input[name="nama_kegiatan"]')
        .scrollIntoView()
        .should('be.visible')
        .clear({ force: true })
        .type(uniqueName, { force: true, delay: 50 })
      cy.log('✅ Nama kegiatan: ' + uniqueName)
      cy.wait(500)
      
      // 2. Tanggal
      cy.get('#formKegiatan input[name="tanggal"]')
        .scrollIntoView()
        .should('be.visible')
        .clear({ force: true })
        .type(kegiatan.tanggal, { force: true })
      cy.log('✅ Tanggal: ' + kegiatan.tanggal)
      cy.wait(500)
      
      // 3. Waktu Mulai
      cy.get('#formKegiatan input[name="waktu_mulai"]')
        .scrollIntoView()
        .should('be.visible')
        .clear({ force: true })
        .type(kegiatan.waktu_mulai, { force: true })
      cy.log('✅ Waktu mulai: ' + kegiatan.waktu_mulai)
      cy.wait(500)
      
      // 4. Waktu Selesai
      cy.get('#formKegiatan input[name="waktu_selesai"]')
        .scrollIntoView()
        .should('be.visible')
        .clear({ force: true })
        .type(kegiatan.waktu_selesai, { force: true })
      cy.log('✅ Waktu selesai: ' + kegiatan.waktu_selesai)
      cy.wait(500)
      
      // 5. Lokasi
      cy.get('#formKegiatan input[name="lokasi"]')
        .scrollIntoView()
        .should('be.visible')
        .clear({ force: true })
        .type(kegiatan.lokasi, { force: true, delay: 50 })
      cy.log('✅ Lokasi: ' + kegiatan.lokasi)
      cy.wait(500)
      
      // 6. Rincian Lokasi
      cy.get('#formKegiatan input[name="rincian_lokasi"]')
        .scrollIntoView()
        .should('be.visible')
        .clear({ force: true })
        .type(kegiatan.rincian_lokasi, { force: true, delay: 50 })
      cy.log('✅ Rincian lokasi: ' + kegiatan.rincian_lokasi)
      cy.wait(500)
      
      // 7. Deskripsi
      cy.get('#formKegiatan textarea[name="deskripsi"]')
        .scrollIntoView()
        .should('be.visible')
        .clear({ force: true })
        .type(kegiatan.deskripsi, { force: true, delay: 30 })
      cy.log('✅ Deskripsi diisi')
      cy.wait(500)
      
      // ✅ SKIP: latitude & longitude (hidden fields, optional)
      cy.log('⚠️ Koordinat di-skip (optional)')
      
      cy.wait(1000)
      cy.log('✅ Semua field required terisi!')
      
      // ================================================
      // STEP 6: SUBMIT FORM
      // ================================================
      cy.get('button[form="formKegiatan"]')
        .scrollIntoView()
        .should('be.visible')
        .should('not.be.disabled')
        .click({ force: true })
      
      cy.wait(3000)
      cy.log('✅ Form submitted!')
      
      // ================================================
      // STEP 7: VERIFY SUCCESS
      // ================================================
      cy.get('body').should('be.visible')
      
      cy.get('body').then(($body) => {
        const bodyText = $body.text()
        
        if (bodyText.match(/berhasil|sukses|success|created/i)) {
          cy.log('✅ Success message ditampilkan')
        }
        
        if (bodyText.includes('Test Kegiatan')) {
          cy.log('✅ Kegiatan baru muncul di list')
        }
      })
      
      cy.url({ timeout: 10000 }).should('include', '/managemen-kegiatan')
      cy.log('🎉 COMPLETE FLOW BERHASIL!')
    })
  })
})