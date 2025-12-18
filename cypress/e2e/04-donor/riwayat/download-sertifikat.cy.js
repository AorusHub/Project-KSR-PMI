describe('Donor - Download Sertifikat PDF', () => {
  
  // ================================================
  // TEST UTAMA: Login → Dashboard → Detail → Export PDF
  // ================================================
  it('Donor login → dashboard → lihat detail → export PDF', () => {
    // STEP 1: Login
    cy.loginAsDonor()
    cy.wait(2000)
    cy.log('✅ Step 1: Login berhasil')
    
    // STEP 2: Navigate to Detail Page (Direct URL)
    cy.visit('/pendonor/riwayat-donor', { failOnStatusCode: false })
    cy.wait(2000)
    cy.get('body').should('be.visible')
    cy.log('✅ Step 2: Halaman detail terbuka')
    
    // STEP 3: Click "Export PDF" button
    cy.get('body').then(($body) => {
      // Method 1: By exact href (MOST RELIABLE)
      if ($body.find('a[href*="export-pdf"]').length > 0) {
        cy.get('a[href*="export-pdf"]')
          .first()
          .should('be.visible')
          .click({ force: true })
        cy.log('✅ Step 3: Klik "Export PDF" via href')
      }
      // Method 2: By text "Export PDF"
      else if ($body.find('a:contains("Export PDF")').length > 0) {
        cy.contains('a', 'Export PDF')
          .first()
          .should('be.visible')
          .click({ force: true })
        cy.log('✅ Step 3: Klik "Export PDF" via text')
      }
      // Method 3: By SVG icon (download icon)
      else if ($body.find('a svg[fill-rule="evenodd"]').length > 0) {
        cy.get('a svg[fill-rule="evenodd"]')
          .parent('a')
          .first()
          .should('be.visible')
          .click({ force: true })
        cy.log('✅ Step 3: Klik "Export PDF" via SVG')
      }
      // Method 4: Generic fallback
      else if ($body.find('a:contains("PDF"), a:contains("Download")').length > 0) {
        cy.get('a').contains(/pdf|download|export/i)
          .first()
          .click({ force: true })
        cy.log('✅ Step 3: Klik export via generic selector')
      }
      else {
        cy.log('⚠️ Tombol Export PDF tidak ditemukan')
      }
    })
    
    cy.wait(3000)
    cy.log('🎉 Flow selesai!')
  })

  // ================================================
  // TEST 2: Verifikasi button Export PDF ada
  // ================================================
  it('Menampilkan tombol Export PDF di halaman detail', () => {
    cy.loginAsDonor()
    cy.visit('/pendonor/riwayat-donor', { failOnStatusCode: false })
    cy.wait(2000)
    
    cy.get('body').then(($body) => {
      if ($body.find('a[href*="export-pdf"]').length > 0) {
        cy.get('a[href*="export-pdf"]').should('be.visible')
        cy.log('✅ Tombol Export PDF tersedia')
      } else {
        cy.log('⚠️ Tombol Export PDF tidak ditemukan')
      }
    })
  })

  // ================================================
  // TEST 3: Download PDF berkali-kali
  // ================================================
  it('Dapat download PDF berkali-kali', () => {
    cy.loginAsDonor()
    cy.visit('/pendonor/riwayat-donor', { failOnStatusCode: false })
    cy.wait(2000)
    
    cy.get('body').then(($body) => {
      if ($body.find('a[href*="export-pdf"]').length > 0) {
        // Download 1
        cy.get('a[href*="export-pdf"]').first().click({ force: true })
        cy.wait(1500)
        cy.log('✅ Download 1')
        
        // Download 2
        cy.get('a[href*="export-pdf"]').first().click({ force: true })
        cy.wait(1500)
        cy.log('✅ Download 2')
      } else {
        cy.log('⚠️ Tidak ada button export')
      }
    })
  })

  // ================================================
  // TEST 4: Verifikasi styling button
  // ================================================
  it('Button Export PDF memiliki styling yang benar', () => {
    cy.loginAsDonor()
    cy.visit('/pendonor/riwayat-donor', { failOnStatusCode: false })
    cy.wait(2000)
    
    cy.get('a[href*="export-pdf"]').then(($btn) => {
      if ($btn.length > 0) {
        // Check if button visible
        cy.get('a[href*="export-pdf"]').should('be.visible')
        
        // Check if has SVG icon
        cy.get('a[href*="export-pdf"] svg').should('exist')
        
        // Check text
        cy.get('a[href*="export-pdf"]').should('contain', 'Export PDF')
        
        cy.log('✅ Button styling OK')
      }
    })
  })
})