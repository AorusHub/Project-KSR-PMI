const { defineConfig } = require('cypress')

module.exports = defineConfig({
  e2e: {
    baseUrl: 'http://localhost:8000',
    supportFile: 'cypress/support/commands.js', // UBAH dari false ke ini
    setupNodeEvents(on, config) {
      on('task', {
        'db:seed'() {
          const exec = require('child_process').exec
          return new Promise((resolve, reject) => {
            exec('php artisan db:seed --class=TestSeeder', (error, stdout, stderr) => {
              if (error) {
                console.error(stderr)
                return reject(error)
              }
              console.log(stdout)
              resolve(null)
            })
          })
        }
      })
    },
    video: true,
    screenshotOnRunFailure: true,
    defaultCommandTimeout: 10000,
    requestTimeout: 10000,
    viewportWidth: 1280,
    viewportHeight: 720,
    specPattern: 'cypress/e2e/**/*.cy.{js,jsx,ts,tsx}',
    retries: {
      runMode: 0, // UBAH dari 2 ke 0
      openMode: 0
    },
    failOnStatusCode: false // SUDAH ADA, pastikan ini tetap false
  }
})