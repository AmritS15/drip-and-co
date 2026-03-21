<style>
    @media (min-width: 1281px) {
        form.form-add-product.tf-section-2 {
            grid-template-columns: minmax(0, 2fr) minmax(0, 3.5fr) !important;
        }
        form.form-add-product.tf-section-2 > .wg-box {
            grid-column: span 1 !important;
        }
    }
    @media (max-width: 1280px) {
        form.form-add-product.tf-section-2 {
            grid-template-columns: minmax(0, 1fr) !important;
        }
        form.form-add-product.tf-section-2 > .wg-box {
            grid-column: 1 / -1 !important;
        }
        form.form-add-product.tf-section-2 fieldset.variants {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }
    }
</style>
