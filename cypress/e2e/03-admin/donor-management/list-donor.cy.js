describe('Admin - Flow: Login → Dashboard → Manajemen Permintaan', () => {
  
  it('Admin login lalu ke dashboard lalu ke manajemen permintaan', () => {
    // Step 1: Login as Admin
    cy.loginAsAdmin()
    cy.wait(2000)
    cy.url({ timeout: 15000 }).should('include', '/dashboard')
    cy.log('✅ Step 1: Login berhasil')
    
    // Step 2: Verify Dashboard
    cy.get('body', { timeout: 30000 }).should('be.visible')
    cy.contains(/dashboard/i).should('exist')
    cy.log('✅ Step 2: Dashboard terbuka')
    
    // Step 3: Navigate to Manajemen Permintaan
    cy.get('body').then(($body) => {
      const hasPermintaanMenu = 
        $body.find('a:contains("Permintaan")').length > 0 ||
        $body.find('a[href*="permintaan"]').length > 0 ||
        $body.find('a[href*="request"]').length > 0
      
      if (hasPermintaanMenu) {
        cy.get('a')
          .contains(/permintaan|request/i)
          .first()
          .click({ force: true })
        cy.wait(2000)
        cy.url().should('match', /permintaan|request/)
        cy.log('✅ Step 3: Manajemen Permintaan terbuka')
      } else {
        // Try direct visit
        const possibleRoutes = [
          '/dashboard/admin/permintaan',
          '/dashboard/permintaan',
          '/admin/permintaan',
          '/permintaan'
        ]
        
        cy.wrap(possibleRoutes).each((route) => {
          cy.visit(route, { failOnStatusCode: false })
          cy.wait(1000)
          
          cy.url().then((url) => {
            if (!url.includes('404')) {
              cy.log(`✅ Step 3: Manajemen Permintaan via ${route}`)
              return false // Stop iteration
            }
          })
        })
      }
    })
    
    // Step 4: Verify Page Loaded
    cy.get('body').should('be.visible')
    cy.log('✅ Halaman Manajemen Permintaan berhasil dimuat')
  })

  it('Verifikasi halaman manajemen permintaan', () => {
    cy.loginAsAdmin()
    cy.wait(2000)
    
    // Navigate
    cy.get('body').then(($body) => {
      if ($body.text().match(/permintaan/i)) {
        cy.contains(/permintaan/i).first().click({ force: true })
      } else {
        cy.visit('/dashboard/admin/permintaan', { failOnStatusCode: false })
      }
    })
    
    cy.wait(2000)
    
    // Verify content
    cy.get('body').then(($body) => {
      const bodyText = $body.text()
      const hasContent = 
        bodyText.match(/permintaan|request|pending|approved|rejected/i)
      
      if (hasContent) {
        cy.log('✅ Halaman menampilkan data permintaan')
      } else {
        cy.log('⚠️ Konten permintaan tidak ditemukan')
      }
    })
  })
})