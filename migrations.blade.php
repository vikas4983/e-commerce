<?php
// 4. Categories Table
Schema::create('categories', function (Blueprint $table) {
    $table->id();
    $table->string('name')->unique();
    $table->boolean('is_active')->default(true);
    $table->timestamps();
});

// 5. Brands Table
Schema::create('brands', function (Blueprint $table) {
    $table->id();
    $table->string('name')->unique();
    $table->timestamps();
});

// 6. Products Table
Schema::create('products', function (Blueprint $table) {
    $table->id();
    $table->foreignId('category_id')->constrained()->onDelete('cascade');
    $table->foreignId('brand_id')->nullable()->constrained()->onDelete('set null');
    $table->string('name');
    $table->decimal('price', 10, 2);
    $table->text('description');
    $table->integer('stock');
    $table->boolean('is_active')->default(true);
    $table->string('image')->nullable();
    $table->timestamps();
});

// 7. Product Variants
Schema::create('product_variants', function (Blueprint $table) {
    $table->id();
    $table->foreignId('product_id')->constrained()->onDelete('cascade');
    $table->string('attribute'); // size, color
    $table->string('value');
    $table->decimal('price', 10, 2)->nullable();
    $table->integer('stock')->default(0);
    $table->timestamps();
});

// 8. Cart Items
Schema::create('cart_items', function (Blueprint $table) {
    $table->id();
    $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade');
    $table->uuid('guest_token')->nullable();
    $table->foreignId('product_id')->constrained()->onDelete('cascade');
    $table->foreignId('variant_id')->nullable()->constrained('product_variants')->onDelete('set null');
    $table->integer('quantity');
    $table->timestamps();
});

// 9. Orders
Schema::create('orders', function (Blueprint $table) {
    $table->id();
    $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
    $table->uuid('guest_token')->nullable();
    $table->decimal('total_amount', 10, 2);
    $table->string('payment_status')->default('pending');
    $table->string('payment_method')->nullable();
    $table->string('order_status')->default('pending');
    $table->timestamps();
});

// 10. Order Items
Schema::create('order_items', function (Blueprint $table) {
    $table->id();
    $table->foreignId('order_id')->constrained()->onDelete('cascade');
    $table->foreignId('product_id')->constrained()->onDelete('cascade');
    $table->foreignId('variant_id')->nullable()->constrained('product_variants')->onDelete('set null');
    $table->integer('quantity');
    $table->decimal('price', 10, 2);
    $table->timestamps();
});

// 11. Addresses
Schema::create('addresses', function (Blueprint $table) {
    $table->id();
    $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade');
    $table->uuid('guest_token')->nullable();
    $table->string('type'); // shipping, billing
    $table->string('full_name');
    $table->string('mobile');
    $table->string('address_line');
    $table->string('city');
    $table->string('state');
    $table->string('postal_code');
    $table->string('country')->default('India');
    $table->timestamps();
});

// 12. Delivery Partners
Schema::create('delivery_partners', function (Blueprint $table) {
    $table->id();
    $table->string('name');
    $table->string('contact_number');
    $table->timestamps();
});

// 13. Order Status Logs
Schema::create('order_status_logs', function (Blueprint $table) {
    $table->id();
    $table->foreignId('order_id')->constrained()->onDelete('cascade');
    $table->string('status');
    $table->text('note')->nullable();
    $table->timestamps();
});

// 14. Coupons
Schema::create('coupons', function (Blueprint $table) {
    $table->id();
    $table->string('code')->unique();
    $table->decimal('discount', 8, 2);
    $table->enum('type', ['fixed', 'percentage']);
    $table->timestamp('valid_from');
    $table->timestamp('valid_until');
    $table->timestamps();
});

// 15. Reviews
Schema::create('reviews', function (Blueprint $table) {
    $table->id();
    $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade');
    $table->foreignId('product_id')->constrained()->onDelete('cascade');
    $table->tinyInteger('rating');
    $table->text('comment')->nullable();
    $table->timestamps();
});

// 16. Wishlists
Schema::create('wishlists', function (Blueprint $table) {
    $table->id();
    $table->foreignId('user_id')->constrained()->onDelete('cascade');
    $table->foreignId('product_id')->constrained()->onDelete('cascade');
    $table->timestamps();
});