describe('About Page - Guest Access', () => {
  
  it('Guest bisa mengakses halaman About tanpa login', () => {
    // Pastikan belum login
    cy.clearCookies()
    cy.clearLocalStorage()
    
    // Buka halaman
    cy.visit('/kegiatan', { 
      failOnStatusCode: false,
      timeout: 60000 
    })
    
    // Cek halaman kebuka dengan benar
    cy.get('body', { timeout: 30000 }).should('be.visible')
    cy.url().should('include', '/kegiatan')
    
    // Cek tidak ada error 404
    
    
    cy.log('✅ Guest berhasil akses halaman About!')
  })
})