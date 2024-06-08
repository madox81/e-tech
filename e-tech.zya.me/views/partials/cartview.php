<!--cartview.php-->
<div data-name="popover-content" style="display: none;">
    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th width="40%">Product</th>
                    <th width="5%">Qty</th>
                    <th width="20%">Price</th>
                    <th width="20%">Total</th>
                    <th width="5%" class="action">Action</th>
                </tr>
            </thead>
            <tbody id="cart-content">
                <!-- Cart items will be dynamically added here -->
            </tbody>
        </table>
    </div>
    <div id = "cart_btns" class="mt-1" align="right">
        <a href="index.php?page=checkout" class="btn btn-primary" id="check_out_cart">
            <i class="bi bi-cart-check"></i> Check out
        </a>
        <a href="" class="btn btn-light " id="clear_cart">
           <i class="bi bi-trash"></i>Clear
        </a>
    </div>
</div>