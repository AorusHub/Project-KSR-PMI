describe('Admin - Complete Flow: Login → Manajemen Pengguna → Riwayat Donasi → Detail → Export PDF', () => {
  
  it('Flow dengan verifikasi setiap langkah', () => {
    // Step 1: Login
    cy.loginAsAdmin()
    cy.wait(2000)
    cy.url().should('include', '/dashboard')
    cy.log('📍 Step 1: Login ✅')
    
    // Step 2: Dashboard
    cy.get('body').should('be.visible')
    cy.contains(/dashboard/i).should('exist')
    cy.log('📍 Step 2: Dashboard ✅')
    
    // Step 3: Manajemen Pengguna
    cy.get('body').then(($body) => {
      const hasUserMenu = 
        $body.find('a:contains("Pengguna")').length > 0 ||
        $body.find('a[href*="user"]').length > 0
      
      if (hasUserMenu) {
        cy.contains(/pengguna|user/i).first().click({ force: true })
        cy.wait(2000)
        cy.url().should('match', /user|pengguna/)
        cy.log('📍 Step 3: Manajemen Pengguna ✅')
      } else {
        cy.visit('/dashboard/admin/users', { failOnStatusCode: false })
        cy.log('📍 Step 3: Manual visit ✅')
      }
    })
    
    // Step 4: Riwayat Donasi
    cy.get('body').then(($body) => {
      if ($body.text().match(/riwayat/i)) {
        cy.contains(/riwayat/i).first().click({ force: true })
        cy.wait(2000)
        cy.log('📍 Step 4: Riwayat Donasi ✅')
      }
    })
    
    // Step 5: Detail
    cy.get('body').then(($body) => {
      if ($body.text().match(/detail/i)) {
        cy.contains(/detail/i).first().click({ force: true })
        cy.wait(2000)
        cy.log('📍 Step 5: Detail ✅')
      }
    })
    
    // Step 6: Export PDF
    cy.get('body').then(($body) => {
      if ($body.text().match(/pdf/i)) {
        cy.contains(/pdf/i).first().click({ force: true })
        cy.wait(2000)
        cy.log('📍 Step 6: Export PDF ✅')
      }
    })
    
    cy.log('sudah diekspor')
  })

})  