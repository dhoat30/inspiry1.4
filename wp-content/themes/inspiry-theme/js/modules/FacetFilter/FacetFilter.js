const $ = jQuery

class FacetFilter {
    constructor() {
        this.mobileFilterButton = $('.mobile .filter-title')
        this.closeButton = $('.mobile-filter-container .close-button')
        this.closeIcon = $('.mobile-filter-container .close-icon')
        this.events()
    }
    events() {
        this.mobileFilterButton.on('click', this.showMobileFilterContainer)
        this.closeButton.on('click', this.closeMobileFilterContainer)
        this.closeIcon.on('click', this.closeMobileFilterContainer)
    }

    showMobileFilterContainer() {
        console.log('filter button clicked')
        $('.facet-wp-container').show()
    }
    closeMobileFilterContainer() {
        $('.facet-wp-container').hide()
    }
}

export default FacetFilter