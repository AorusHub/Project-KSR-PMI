

  // ============================================
  // TEST 2: STEP BY STEP WITH VERIFICATION
  // ============================================
  it('Flow dengan verifikasi setiap step', () => {
    // Step 1: Login
    cy.fixture('users').then((users) => {
      cy.visit('/login', { failOnStatusCode: false })
      cy.get('input[name="email"]').type(users.admin.email)
      cy.get('input[name="password"]').type(users.admin.password)
      cy.get('button[type="submit"]').click()
      cy.wait(2000)
      cy.url().should('include', '/dashboard')
      cy.log('✅ Login berhasil')
    })
    
    // Step 2: Dashboard loaded
    cy.get('body').should('be.visible')
    cy.contains(/dashboard/i).should('exist')
    cy.log('✅ Dashboard terbuka')
    
    // Step 3: Navigate to Kegiatan
    cy.get('body').then(($body) => {
      const bodyText = $body.text()
      
      if (bodyText.match(/kegiatan/i)) {
        cy.contains(/kegiatan/i).first().click({ force: true })
      } else {
        cy.visit('/dashboard/admin/kegiatan', { failOnStatusCode: false })
      }
    })
    
    cy.wait(2000)
    cy.url().should('include', '/kegiatan')
    cy.log('✅ Halaman kegiatan terbuka')
    
    // Step 4: Click Detail
    cy.get('body').then(($body) => {
      if ($body.text().match(/detail/i)) {
        cy.contains(/detail/i).first().click({ force: true })
        cy.wait(2000)
        cy.log('✅ Detail terbuka')
        
        // Verify content
        cy.get('body').invoke('text').should('have.length.greaterThan', 50)
      }
    })
  })

  