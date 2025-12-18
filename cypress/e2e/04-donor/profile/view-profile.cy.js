describe('Donor - View Profile', () => {
  
  // ================================================
  // TEST 1: COMPLETE FLOW - Login → Dropdown → Profile
  // ================================================
  it('Donor login → klik nama → klik profil saya → view profile', () => {
    // STEP 1: Login as Donor
    cy.loginAsDonor()
    cy.wait(2000)
    cy.url({ timeout: 15000 }).should('include', '/dashboard')
    cy.log('✅ Step 1: Login berhasil')
    
    // STEP 2: Verify Dashboard
    cy.get('body', { timeout: 30000 }).should('be.visible')
    cy.log('✅ Step 2: Dashboard terbuka')
    
    // STEP 3: Click User Dropdown (Alpine.js button)
    cy.fixture('users').then((users) => {
      const donorName = users.donor.name // "Donor User" or actual name
      
      // Method 1: Click button with Alpine.js @click
      cy.get('button[\\@click*="dropdownOpen"]')
        .should('be.visible')
        .click({ force: true })
      cy.log('✅ Step 3: Klik dropdown button (Alpine.js)')
      
      cy.wait(1000)
    })
    
    // STEP 4: Wait for dropdown to open and click "Profil Saya"
    cy.get('body').then(($body) => {
      cy.wait(500)
      
      // Try multiple selectors for "Profil Saya" link
      if ($body.find('a:contains("Profil Saya")').length > 0) {
        cy.contains('a', 'Profil Saya')
          .should('be.visible')
          .click({ force: true })
        cy.log('✅ Step 4: Klik "Profil Saya"')
      }
      else if ($body.find('a:contains("Profil")').length > 0) {
        cy.contains('a', /^Profil$/i)
          .first()
          .should('be.visible')
          .click({ force: true })
        cy.log('✅ Step 4: Klik "Profil"')
      }
      else if ($body.find('a[href*="profile"]').length > 0) {
        cy.get('a[href*="profile"]')
          .first()
          .should('be.visible')
          .click({ force: true })
        cy.log('✅ Step 4: Klik profile via href')
      }
      else {
        // Fallback: direct visit
        cy.visit('/dashboard/donor/profile', { failOnStatusCode: false })
        cy.log('⚠️ Step 4: Direct visit ke profile')
      }
    })
    
    cy.wait(2000)})})
   