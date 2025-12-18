// ***********************************************
// Custom commands for KSR-PMI Testing
// ***********************************************

// ============================================
// AUTHENTICATION COMMANDS
// ============================================

/**
 * Login as Admin - Simple version without session
 */
Cypress.Commands.add('loginAsAdmin', () => {
  cy.visit('/login')
  cy.fixture('users').then((users) => {
    cy.get('input[name="email"]').clear().type(users.admin.email)
    cy.get('input[name="password"]').clear().type(users.admin.password)
    cy.get('button[type="submit"]').click()
    
    // Wait for redirect
    cy.url().should('include', '/dashboard', { timeout: 10000 })
    cy.wait(1000)
  })
})

/**
 * Login as Donor - Simple version without session
 */
Cypress.Commands.add('loginAsDonor', () => {
  cy.visit('/login')
  cy.fixture('users').then((users) => {
    cy.get('input[name="email"]').clear().type(users.donor.email)
    cy.get('input[name="password"]').clear().type(users.donor.password)
    cy.get('button[type="submit"]').click()
    
    // Wait for redirect
    cy.url().should('include', '/dashboard', { timeout: 10000 })
    cy.wait(1000)
  })
})

/**
 * Logout
 */
Cypress.Commands.add('logout', () => {
  cy.get('body').then(($body) => {
    // Try to find logout button/link
    const logoutSelectors = [
      'a[href*="logout"]',
      'button:contains("Logout")',
      'button:contains("Keluar")',
      'a:contains("Logout")',
      'a:contains("Keluar")',
      'form[action*="logout"]'
    ]
    
    let found = false
    
    for (const selector of logoutSelectors) {
      if ($body.find(selector).length > 0) {
        if (selector.includes('form')) {
          cy.get(selector).submit()
        } else {
          cy.get(selector).first().click({ force: true })
        }
        found = true
        break
      }
    }
    
    // Fallback: clear session manually
    if (!found) {
      cy.clearCookies()
      cy.clearLocalStorage()
    }
    
    cy.wait(1000)
  })
})

// ============================================
// PAGE VERIFICATION COMMANDS
// ============================================

/**
 * Check if page exists (not 404 or 500)
 */
Cypress.Commands.add('checkPageExists', () => {
  cy.get('body').should('exist')
  cy.get('body').should('not.contain', '404')
  cy.get('body').should('not.contain', '500')
  cy.get('body').should('not.contain', 'Not Found')
  cy.get('body').should('not.contain', 'Server Error')
})

/**
 * Check if user is on dashboard
 */
Cypress.Commands.add('checkDashboard', () => {
  cy.url().should('include', '/dashboard')
  cy.get('body').should('contain', /dashboard|beranda/i)
})

// ============================================
// FORM COMMANDS
// ============================================

/**
 * Fill login form
 */
Cypress.Commands.add('fillLoginForm', (email, password) => {
  cy.get('input[name="email"]').clear().type(email)
  cy.get('input[name="password"]').clear().type(password)
})

/**
 * Fill register form
 */
Cypress.Commands.add('fillRegisterForm', (userData) => {
  cy.get('input[name="name"]').clear().type(userData.name)
  cy.get('input[name="email"]').clear().type(userData.email)
  cy.get('input[name="password"]').clear().type(userData.password)
  cy.get('input[name="password_confirmation"]').clear().type(userData.password)
  
  cy.get('body').then(($body) => {
    if ($body.find('input[name="phone"]').length > 0) {
      cy.get('input[name="phone"]').type(userData.phone)
    }
    if ($body.find('select[name="golongan_darah"]').length > 0) {
      cy.get('select[name="golongan_darah"]').select(userData.golongan_darah)
    }
    if ($body.find('input[name="tanggal_lahir"]').length > 0) {
      cy.get('input[name="tanggal_lahir"]').type(userData.tanggal_lahir)
    }
    if ($body.find('textarea[name="alamat"]').length > 0) {
      cy.get('textarea[name="alamat"]').type(userData.alamat)
    }
  })
})

/**
 * Fill kegiatan form
 */
Cypress.Commands.add('fillKegiatanForm', (kegiatanData) => {
  cy.get('input[name="nama_kegiatan"]').clear().type(kegiatanData.nama)
  cy.get('textarea[name="deskripsi"]').clear().type(kegiatanData.deskripsi)
  cy.get('input[name="tanggal"]').clear().type(kegiatanData.tanggal)
  cy.get('input[name="lokasi"]').clear().type(kegiatanData.lokasi)
  cy.get('input[name="kuota"]').clear().type(kegiatanData.kuota)
})

// ============================================
// DATA COMMANDS
// ============================================

/**
 * Create kegiatan via UI
 */
Cypress.Commands.add('createKegiatan', (kegiatanData) => {
  cy.visit('/dashboard/admin/kegiatan-donor/create')
  cy.fillKegiatanForm(kegiatanData)
  cy.get('button[type="submit"]').click()
  cy.wait(2000)
})

/**
 * Delete first kegiatan
 */
Cypress.Commands.add('deleteFirstKegiatan', () => {
  cy.visit('/dashboard/admin/kegiatan-donor')
  cy.get('body').then(($body) => {
    if ($body.find('button:contains("Hapus"), a:contains("Hapus")').length > 0) {
      cy.get('button, a').contains(/hapus|delete/i).first().click({ force: true })
      cy.wait(500)
      cy.get('button').contains(/ya|confirm|hapus/i).click({ force: true })
      cy.wait(2000)
    }
  })
})

// ============================================
// WAIT COMMANDS
// ============================================

/**
 * Wait for page load
 */
Cypress.Commands.add('waitForPageLoad', () => {
  cy.get('body').should('be.visible')
  cy.wait(1000)
})

/**
 * Wait for element with retry
 */
Cypress.Commands.add('waitForElement', (selector, timeout = 10000) => {
  cy.get(selector, { timeout }).should('be.visible')
})

// ============================================
// SCREENSHOT COMMANDS
// ============================================

/**
 * Take screenshot with timestamp
 */
Cypress.Commands.add('screenshotWithTimestamp', (name) => {
  const timestamp = new Date().toISOString().replace(/:/g, '-').split('.')[0]
  cy.screenshot(`${name}-${timestamp}`)
})

// ============================================
// ASSERTION HELPERS
// ============================================

/**
 * Check if element contains any text
 */
Cypress.Commands.add('shouldHaveText', (selector) => {
  cy.get(selector).invoke('text').should('not.be.empty')
})

/**
 * Check if table has rows
 */
Cypress.Commands.add('tableHasRows', (selector = 'table') => {
  cy.get(selector).find('tbody tr').should('have.length.greaterThan', 0)
})