describe('E2E - Complete Donor Flow', () => {
  const uniqueEmail = `donor${Date.now()}@test.com`
  let donorData

  before(() => {
    cy.fixture('users').then((users) => {
      donorData = { ...users.newDonor, email: uniqueEmail }
    })
  })

  it('Full Flow: Register → Login → Profile → Daftar Kegiatan → View Status → Riwayat', () => {
    // ============ STEP 1: REGISTER ============
    cy.log('STEP 1: Register donor baru')
    cy.visit('/register')
    
    cy.get('input[name="name"]').type(donorData.name)
    cy.get('input[name="email"]').type(donorData.email)
    cy.get('input[name="password"]').type(donorData.password)
    cy.get('input[name="password_confirmation"]').type(donorData.password)
    
    cy.get('body').then(($body) => {
      if ($body.find('input[name="phone"]').length) {
        cy.get('input[name="phone"]').type(donorData.phone)
      }
      if ($body.find('select[name="golongan_darah"]').length) {
        cy.get('select[name="golongan_darah"]').select(donorData.golongan_darah)
      }
      if ($body.find('input[name="tanggal_lahir"]').length) {
        cy.get('input[name="tanggal_lahir"]').type(donorData.tanggal_lahir)
      }
      if ($body.find('textarea[name="alamat"]').length) {
        cy.get('textarea[name="alamat"]').type(donorData.alamat)
      }
    })
    
    cy.get('button[type="submit"]').click()
    
    // ============ STEP 2: VERIFY LOGIN ============
    cy.log('STEP 2: Verifikasi login berhasil')
    cy.url().should('include', '/dashboard')
    cy.contains(/dashboard|beranda/i).should('be.visible')
    
    // ============ STEP 3: VIEW & EDIT PROFILE ============
    cy.log('STEP 3: Lihat dan edit profile')
    cy.visit('/dashboard/donor/profile')
    cy.contains(donorData.name).should('be.visible')
    
    cy.get('body').then(($body) => {
      if ($body.find('a:contains("Edit"), button:contains("Edit")').length > 0) {
        cy.get('a, button').contains(/edit/i).click()
        cy.get('input[name="name"]').should('have.value', donorData.name)
      }
    })
    
    // ============ STEP 4: LIHAT KEGIATAN ============
    cy.log('STEP 4: Lihat daftar kegiatan')
    cy.visit('/dashboard/donor/kegiatan')
    cy.checkPageExists()
    cy.get('table, .card, .kegiatan-item').should('exist')
    
    // ============ STEP 5: DAFTAR KEGIATAN ============
    cy.log('STEP 5: Daftar ke kegiatan donor')
    cy.get('body').then(($body) => {
      if ($body.find('button:contains("Daftar")').length > 0) {
        cy.get('button, a').contains(/daftar/i).first().click()
        
        cy.get('body').then(($confirmBody) => {
          if ($confirmBody.find('button:contains("Ya")').length > 0) {
            cy.get('button').contains(/ya|confirm/i).click()
          }
        })
        
        cy.contains(/berhasil|success/i, { timeout: 10000 }).should('be.visible')
      }
    })
    
    // ============ STEP 6: CEK STATUS PENDAFTARAN ============
    cy.log('STEP 6: Cek status pendaftaran')
    cy.visit('/dashboard/donor/pendaftaran')
    cy.checkPageExists()
    cy.contains(/pending|menunggu/i).should('be.visible')
    
    // ============ STEP 7: ADMIN APPROVE ============
    cy.log('STEP 7: Admin approve pendaftaran')
    cy.logout()
    cy.loginAsAdmin()
    cy.visit('/dashboard/admin/pendaftaran')
    
    cy.get('body').then(($body) => {
      if ($body.find('button:contains("Approve")').length > 0) {
        cy.get('button, a').contains(/approve/i).first().click()
        cy.get('button').contains(/ya/i).click()
        cy.wait(2000)
      }
    })
    
    // ============ STEP 8: DONOR CEK APPROVAL ============
    cy.log('STEP 8: Donor cek approval')
    cy.logout()
    cy.visit('/login')
    cy.get('input[name="email"]').type(donorData.email)
    cy.get('input[name="password"]').type(donorData.password)
    cy.get('button[type="submit"]').click()
    
    cy.visit('/dashboard/donor/pendaftaran')
    cy.contains(/approved|disetujui/i).should('be.visible')
    
    // ============ STEP 9: CEK RIWAYAT ============
    cy.log('STEP 9: Cek riwayat donor')
    cy.visit('/dashboard/donor/riwayat', { failOnStatusCode: false })
    cy.checkPageExists()
    cy.contains(/riwayat|history/i).should('be.visible')
    
    // ============ STEP 10: LOGOUT ============
    cy.log('STEP 10: Logout')
    cy.logout()
    cy.url().should('include', '/login')
  })

  it('Flow: Donor daftar → Cancel → Daftar lagi', () => {
    cy.loginAsDonor()
    
    // Daftar kegiatan
    cy.visit('/dashboard/donor/kegiatan')
    cy.get('body').then(($body) => {
      if ($body.find('button:contains("Daftar")').length > 0) {
        cy.get('button, a').contains(/daftar/i).first().click()
        cy.get('button').contains(/ya/i).click()
        cy.wait(2000)
      }
    })
    
    // Cancel pendaftaran
    cy.visit('/dashboard/donor/pendaftaran')
    cy.get('body').then(($body) => {
      if ($body.find('button:contains("Batal")').length > 0) {
        cy.get('button, a').contains(/batal/i).first().click()
        cy.get('button').contains(/ya/i).click()
        cy.wait(2000)
      }
    })
    
    // Daftar lagi
    cy.visit('/dashboard/donor/kegiatan')
    cy.get('body').then(($body) => {
      if ($body.find('button:contains("Daftar")').length > 0) {
        cy.get('button, a').contains(/daftar/i).first().click()
        cy.get('button').contains(/ya/i).click()
        cy.contains(/berhasil/i).should('be.visible')
      }
    })
  })

  it('Flow: Multiple donors register for same event', () => {
    const donor1Email = `donor1_${Date.now()}@test.com`
    const donor2Email = `donor2_${Date.now()}@test.com`
    
    // Donor 1 register dan daftar
    cy.visit('/register')
    cy.fixture('users').then((users) => {
      const newDonor1 = { ...users.newDonor, email: donor1Email }
      cy.get('input[name="name"]').type(newDonor1.name)
      cy.get('input[name="email"]').type(newDonor1.email)
      cy.get('input[name="password"]').type(newDonor1.password)
      cy.get('input[name="password_confirmation"]').type(newDonor1.password)
      cy.get('button[type="submit"]').click()
      
      cy.url().should('include', '/dashboard')
      cy.visit('/dashboard/donor/kegiatan')
      
      cy.get('body').then(($body) => {
        if ($body.find('button:contains("Daftar")').length > 0) {
          cy.get('button, a').contains(/daftar/i).first().click()
          cy.get('button').contains(/ya/i).click()
        }
      })
    })
    
    // Logout donor 1
    cy.logout()
    
    // Donor 2 register dan daftar kegiatan yang sama
    cy.visit('/register')
    cy.fixture('users').then((users) => {
      const newDonor2 = { ...users.newDonor, email: donor2Email, name: 'Donor Test 2' }
      cy.get('input[name="name"]').type(newDonor2.name)
      cy.get('input[name="email"]').type(newDonor2.email)
      cy.get('input[name="password"]').type(newDonor2.password)
      cy.get('input[name="password_confirmation"]').type(newDonor2.password)
      cy.get('button[type="submit"]').click()
      
      cy.url().should('include', '/dashboard')
      cy.visit('/dashboard/donor/kegiatan')
      
      cy.get('body').then(($body) => {
        if ($body.find('button:contains("Daftar")').length > 0) {
          cy.get('button, a').contains(/daftar/i).first().click()
          cy.get('button').contains(/ya/i).click()
          cy.contains(/berhasil/i).should('be.visible')
        }
      })
    })
  })
})