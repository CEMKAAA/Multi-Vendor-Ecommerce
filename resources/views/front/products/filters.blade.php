<?php use App\Models\Category; use App\Models\Product; use App\Models\Brand;?>
<!-- Shop-Left-Side-Bar-Wrapper -->
<div class="col-lg-3 col-md-3 col-sm-12">
    <!-- Fetch-Categories-from-Root-Category  -->
    <div class="fetch-categories">
        <?php $parentCategories = Category::getParentCategories();?>
        <h3 class="title-name">Kategoriler</h3>
        <!-- Level 1 -->
        @foreach($parentCategories as $category)

            <h3 class="fetch-mark-category">
                <?php $product_counts = Product::getParentCount($category['id']);?>
                <a href="{{ url($category['url']) }}">{{ $category['category_name'] }}
                    <span class="total-fetch-items">({{ $product_counts }})</span>
                </a>
            </h3>
            <?php $childCategories = Category::getChildCategories($category['id']); ?>
            <ul>
                @foreach ($childCategories as $child)
                    <?php $childCount = Category::getChildCount($child['id']);?>
                    <li>
                        <a href="{{ url($child['url']) }}">{{ $child['category_name'] }}
                            <span class="total-fetch-items">({{ $childCount }})</span>
                        </a>
                    </li>
                @endforeach
            </ul>

        @endforeach
        <!-- //end Level 1 -->
    </div>
    <!-- Fetch-Categories-from-Root-Category  /- -->
    <!-- Filters -->
    <!-- Filter-Brand -->
    <div class="facet-filter-associates">
        <h3 class="title-name">Markalar</h3>
        <?php $brands = Brand::getBrands(); $count = 0;?>
        <form class="facet-form" action="#" method="post">
            <div class="associate-wrapper">
            @foreach ($brands as $brand)
                <?php $product_count = Brand::getProductCount($brand['id']);?>
                <input type="checkbox" class="check-box" id="cbs-{{21+$count}}">
                <label class="label-text" for="cbs-{{ 21+$count }}">{{ $brand['name'] }}
                    <span class="total-fetch-items">({{ $product_count }})</span>
                </label>
                <?php $count++;?>
            @endforeach
            </div>
        </form>
    </div>
    <!-- Filter-Brand /- -->
    <!-- Filter-Price -->
    <div class="facet-filter-by-price">
        <h3 class="title-name">Fiyat</h3>
        <form class="facet-form" action="#" method="post">
            <!-- Final-Result -->
            <div class="amount-result clearfix">
                <div class="price-from">₺0</div>
                <div class="price-to">₺4000</div>
            </div>
            <!-- Final-Result /- -->
            <!-- Range-Slider  -->
            <div class="price-filter"></div>
            <!-- Range-Slider /- -->
            <!-- Range-Manipulator -->
            <div class="price-slider-range" data-min="0" data-max="8000" data-default-low="0" data-default-high="4000" data-currency="₺"></div>
            <!-- Range-Manipulator /- -->
            <button type="submit" class="button button-primary">Filtrele</button>
        </form>
    </div>
    <!-- Filter-Price /- -->
    <!-- Filter-Free-Shipping -->
    <div class="facet-filter-by-shipping">
        <h3 class="title-name">Shipping</h3>
        <form class="facet-form" action="#" method="post">
            <input type="checkbox" class="check-box" id="cb-free-ship">
            <label class="label-text" for="cb-free-ship">Ücretsiz kargo</label>
        </form>
    </div>
    <!-- Filter-Free-Shipping /- -->
    <!-- Filter-Rating -->
    <div class="facet-filter-by-rating">
        <h3 class="title-name">Değerlendirmeler</h3>
        <div class="facet-form">
            <!-- 5 Stars -->
            <div class="facet-link">
                <div class="item-stars">
                    <div class='star'>
                        <span style='width:76px'></span>
                    </div>
                </div>
                <span class="total-fetch-items">(0)</span>
            </div>
            <!-- 5 Stars /- -->
            <!-- 4 & Up Stars -->
            <div class="facet-link">
                <div class="item-stars">
                    <div class='star'>
                        <span style='width:60px'></span>
                    </div>
                </div>
                <span class="total-fetch-items">& Up (5)</span>
            </div>
            <!-- 4 & Up Stars /- -->
            <!-- 3 & Up Stars -->
            <div class="facet-link">
                <div class="item-stars">
                    <div class='star'>
                        <span style='width:45px'></span>
                    </div>
                </div>
                <span class="total-fetch-items">& Up (0)</span>
            </div>
            <!-- 3 & Up Stars /- -->
            <!-- 2 & Up Stars -->
            <div class="facet-link">
                <div class="item-stars">
                    <div class='star'>
                        <span style='width:30px'></span>
                    </div>
                </div>
                <span class="total-fetch-items">& Up (0)</span>
            </div>
            <!-- 2 & Up Stars /- -->
            <!-- 1 & Up Stars -->
            <div class="facet-link">
                <div class="item-stars">
                    <div class='star'>
                        <span style='width:15px'></span>
                    </div>
                </div>
                <span class="total-fetch-items">& Up (0)</span>
            </div>
            <!-- 1 & Up Stars /- -->
        </div>
    </div>
    <!-- Filter-Rating -->
    <!-- Filters /- -->
</div>
<!-- Shop-Left-Side-Bar-Wrapper /- -->