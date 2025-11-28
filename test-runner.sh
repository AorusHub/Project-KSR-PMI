#!/bin/bash

# Project-KSR-PMI Test Automation Script
# Usage: ./test-runner.sh [options]

set -e

# Colors for output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
NC='\033[0m' # No Color

# Default configuration
RUN_UNIT=true
RUN_FEATURE=true
RUN_BROWSER=false
GENERATE_COVERAGE=false
PARALLEL=false
STOP_ON_FAILURE=false
VERBOSE=false
FILTER=""

# Function to display usage
usage() {
    echo "KSR-PMI Test Runner"
    echo ""
    echo "Usage: $0 [OPTIONS]"
    echo ""
    echo "Options:"
    echo "  -u, --unit           Run unit tests only"
    echo "  -f, --feature        Run feature tests only"
    echo "  -b, --browser        Run browser tests"
    echo "  -a, --all            Run all tests (default)"
    echo "  -c, --coverage       Generate coverage report"
    echo "  -p, --parallel       Run tests in parallel"
    echo "  -s, --stop-failure   Stop on first failure"
    echo "  -v, --verbose        Verbose output"
    echo "  --filter=PATTERN     Filter tests by pattern"
    echo "  --setup              Setup test environment"
    echo "  --clean              Clean test artifacts"
    echo "  -h, --help           Show this help message"
    echo ""
    echo "Examples:"
    echo "  $0 -u -c                    # Run unit tests with coverage"
    echo "  $0 -f --filter=Login        # Run feature tests matching 'Login'"
    echo "  $0 -b                       # Run browser tests"
    echo "  $0 --setup                  # Setup test environment"
}

# Function to print colored output
print_status() {
    local color=$1
    local message=$2
    echo -e "${color}[$(date '+%Y-%m-%d %H:%M:%S')] ${message}${NC}"
}

# Function to setup test environment
setup_environment() {
    print_status $BLUE "Setting up test environment..."
    
    # Copy environment file
    if [[ ! -f .env.testing ]]; then
        cp .env.example .env.testing
        print_status $GREEN "Created .env.testing file"
    fi
    
    # Install dependencies
    print_status $BLUE "Installing PHP dependencies..."
    composer install --no-interaction --prefer-dist --optimize-autoloader
    
    # Install Node dependencies
    print_status $BLUE "Installing Node dependencies..."
    npm install
    
    # Generate application key for testing
    print_status $BLUE "Generating application key..."
    php artisan key:generate --env=testing
    
    # Create storage directories
    mkdir -p storage/framework/sessions
    mkdir -p storage/framework/views
    mkdir -p storage/framework/cache
    mkdir -p storage/logs
    mkdir -p build/coverage
    
    # Set permissions
    chmod -R 755 storage/
    chmod -R 755 bootstrap/cache/
    
    # Clear cache
    php artisan config:clear
    php artisan cache:clear
    php artisan view:clear
    
    print_status $GREEN "Test environment setup complete!"
}

# Function to clean test artifacts
clean_artifacts() {
    print_status $BLUE "Cleaning test artifacts..."
    
    rm -rf build/
    rm -rf storage/framework/cache/data/*
    rm -rf storage/framework/sessions/*
    rm -rf storage/framework/views/*
    rm -rf storage/logs/*
    
    print_status $GREEN "Test artifacts cleaned!"
}

# Function to check prerequisites
check_prerequisites() {
    print_status $BLUE "Checking prerequisites..."
    
    # Check PHP version
    PHP_VERSION=$(php -r "echo PHP_VERSION;")
    if [[ "$(printf '%s\n' "8.2" "$PHP_VERSION" | sort -V | head -n1)" != "8.2" ]]; then
        print_status $RED "Error: PHP 8.2+ is required. Found: $PHP_VERSION"
        exit 1
    fi
    
    # Check if composer is installed
    if ! command -v composer &> /dev/null; then
        print_status $RED "Error: Composer is not installed"
        exit 1
    fi
    
    # Check if SQLite extension is available
    if ! php -m | grep -q sqlite3; then
        print_status $RED "Error: SQLite3 PHP extension is not installed"
        exit 1
    fi
    
    print_status $GREEN "Prerequisites check passed!"
}

# Function to run unit tests
run_unit_tests() {
    print_status $BLUE "Running unit tests..."
    
    local cmd="php artisan test --testsuite=Unit"
    
    if [[ $VERBOSE == true ]]; then
        cmd="$cmd --verbose"
    fi
    
    if [[ $STOP_ON_FAILURE == true ]]; then
        cmd="$cmd --stop-on-failure"
    fi
    
    if [[ ! -z "$FILTER" ]]; then
        cmd="$cmd --filter=$FILTER"
    fi
    
    if [[ $GENERATE_COVERAGE == true ]]; then
        cmd="$cmd --coverage-html build/coverage/unit"
    fi
    
    eval $cmd
}

# Function to run feature tests
run_feature_tests() {
    print_status $BLUE "Running feature tests..."
    
    local cmd="php artisan test --testsuite=Feature"
    
    if [[ $VERBOSE == true ]]; then
        cmd="$cmd --verbose"
    fi
    
    if [[ $STOP_ON_FAILURE == true ]]; then
        cmd="$cmd --stop-on-failure"
    fi
    
    if [[ ! -z "$FILTER" ]]; then
        cmd="$cmd --filter=$FILTER"
    fi
    
    if [[ $GENERATE_COVERAGE == true ]]; then
        cmd="$cmd --coverage-html build/coverage/feature"
    fi
    
    eval $cmd
}

# Function to run browser tests
run_browser_tests() {
    print_status $BLUE "Running browser tests..."
    
    # Check if Dusk is installed
    if ! grep -q "laravel/dusk" composer.json; then
        print_status $YELLOW "Installing Laravel Dusk..."
        composer require --dev laravel/dusk
        php artisan dusk:install
    fi
    
    local cmd="php artisan dusk"
    
    if [[ ! -z "$FILTER" ]]; then
        cmd="$cmd --filter=$FILTER"
    fi
    
    eval $cmd
}

# Function to run all tests
run_all_tests() {
    print_status $BLUE "Running all test suites..."
    
    local cmd="php artisan test"
    
    if [[ $VERBOSE == true ]]; then
        cmd="$cmd --verbose"
    fi
    
    if [[ $STOP_ON_FAILURE == true ]]; then
        cmd="$cmd --stop-on-failure"
    fi
    
    if [[ ! -z "$FILTER" ]]; then
        cmd="$cmd --filter=$FILTER"
    fi
    
    if [[ $GENERATE_COVERAGE == true ]]; then
        cmd="$cmd --coverage-html build/coverage/all"
    fi
    
    if [[ $PARALLEL == true ]]; then
        # Install paratest if not available
        if ! grep -q "brianium/paratest" composer.json; then
            print_status $YELLOW "Installing ParaTest..."
            composer require --dev brianium/paratest
        fi
        cmd="./vendor/bin/paratest"
    fi
    
    eval $cmd
}

# Function to generate coverage report
generate_coverage_report() {
    print_status $BLUE "Generating comprehensive coverage report..."
    
    php artisan test --coverage-html build/coverage/comprehensive --coverage-clover build/coverage/clover.xml
    
    if [[ -f build/coverage/comprehensive/index.html ]]; then
        print_status $GREEN "Coverage report generated: build/coverage/comprehensive/index.html"
    fi
}

# Function to run quality checks
run_quality_checks() {
    print_status $BLUE "Running code quality checks..."
    
    # PHP CS Fixer
    if command -v php-cs-fixer &> /dev/null; then
        print_status $BLUE "Running PHP CS Fixer..."
        php-cs-fixer fix --dry-run --diff
    fi
    
    # PHPStan (if available)
    if command -v phpstan &> /dev/null; then
        print_status $BLUE "Running PHPStan..."
        phpstan analyse
    fi
    
    # Psalm (if available)
    if command -v psalm &> /dev/null; then
        print_status $BLUE "Running Psalm..."
        psalm
    fi
}

# Main execution
main() {
    # Parse command line arguments
    while [[ $# -gt 0 ]]; do
        case $1 in
            -u|--unit)
                RUN_UNIT=true
                RUN_FEATURE=false
                RUN_BROWSER=false
                shift
                ;;
            -f|--feature)
                RUN_UNIT=false
                RUN_FEATURE=true
                RUN_BROWSER=false
                shift
                ;;
            -b|--browser)
                RUN_UNIT=false
                RUN_FEATURE=false
                RUN_BROWSER=true
                shift
                ;;
            -a|--all)
                RUN_UNIT=true
                RUN_FEATURE=true
                RUN_BROWSER=false
                shift
                ;;
            -c|--coverage)
                GENERATE_COVERAGE=true
                shift
                ;;
            -p|--parallel)
                PARALLEL=true
                shift
                ;;
            -s|--stop-failure)
                STOP_ON_FAILURE=true
                shift
                ;;
            -v|--verbose)
                VERBOSE=true
                shift
                ;;
            --filter=*)
                FILTER="${1#*=}"
                shift
                ;;
            --setup)
                setup_environment
                exit 0
                ;;
            --clean)
                clean_artifacts
                exit 0
                ;;
            -h|--help)
                usage
                exit 0
                ;;
            *)
                print_status $RED "Unknown option: $1"
                usage
                exit 1
                ;;
        esac
    done
    
    # Check prerequisites
    check_prerequisites
    
    # Record start time
    START_TIME=$(date +%s)
    
    print_status $BLUE "Starting KSR-PMI test execution..."
    print_status $BLUE "Configuration:"
    print_status $BLUE "  Unit Tests: $RUN_UNIT"
    print_status $BLUE "  Feature Tests: $RUN_FEATURE"
    print_status $BLUE "  Browser Tests: $RUN_BROWSER"
    print_status $BLUE "  Generate Coverage: $GENERATE_COVERAGE"
    print_status $BLUE "  Parallel Execution: $PARALLEL"
    print_status $BLUE "  Stop on Failure: $STOP_ON_FAILURE"
    print_status $BLUE "  Verbose: $VERBOSE"
    if [[ ! -z "$FILTER" ]]; then
        print_status $BLUE "  Filter: $FILTER"
    fi
    echo ""
    
    # Run tests based on configuration
    EXIT_CODE=0
    
    if [[ $RUN_UNIT == true && $RUN_FEATURE == true && $RUN_BROWSER == false ]]; then
        run_all_tests || EXIT_CODE=$?
    else
        if [[ $RUN_UNIT == true ]]; then
            run_unit_tests || EXIT_CODE=$?
        fi
        
        if [[ $RUN_FEATURE == true ]]; then
            run_feature_tests || EXIT_CODE=$?
        fi
        
        if [[ $RUN_BROWSER == true ]]; then
            run_browser_tests || EXIT_CODE=$?
        fi
    fi
    
    # Generate additional coverage report if requested
    if [[ $GENERATE_COVERAGE == true ]]; then
        generate_coverage_report
    fi
    
    # Calculate execution time
    END_TIME=$(date +%s)
    DURATION=$((END_TIME - START_TIME))
    
    # Print summary
    echo ""
    print_status $BLUE "========================="
    print_status $BLUE "Test Execution Summary"
    print_status $BLUE "========================="
    print_status $BLUE "Total Duration: ${DURATION}s"
    
    if [[ $EXIT_CODE -eq 0 ]]; then
        print_status $GREEN "All tests passed successfully! ✅"
    else
        print_status $RED "Some tests failed! ❌"
    fi
    
    if [[ $GENERATE_COVERAGE == true ]]; then
        print_status $BLUE "Coverage reports generated in: build/coverage/"
    fi
    
    exit $EXIT_CODE
}

# Run main function
main "$@"