<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('icon')->nullable();
            $table->text('description')->nullable();
            $table->timestamps();
        });

        Schema::create('destinations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('region'); // Bari, Nugaal, Mudug, Sanaag, Sool, Karkaar, Haylaan, Gardafuul
            $table->string('city');
            $table->text('description');
            $table->decimal('latitude', 10, 7);
            $table->decimal('longitude', 10, 7);
            $table->string('featured_image');
            $table->json('gallery')->nullable();
            $table->decimal('entry_fee', 10, 2)->default(0.00);
            $table->decimal('rating', 3, 2)->default(4.80);
            $table->boolean('is_featured')->default(true);
            $table->string('best_season')->nullable();
            $table->timestamps();
        });

        Schema::create('tour_packages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('destination_id')->constrained()->onDelete('cascade');
            $table->string('title');
            $table->string('slug')->unique();
            $table->integer('duration_days');
            $table->decimal('price_per_person', 10, 2);
            $table->integer('max_capacity')->default(20);
            $table->json('included_services')->nullable();
            $table->json('itinerary')->nullable();
            $table->date('start_date')->nullable();
            $table->string('status')->default('active');
            $table->timestamps();
        });

        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->string('booking_code')->unique();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('tour_package_id')->constrained()->onDelete('cascade');
            $table->date('travel_date');
            $table->integer('number_of_guests');
            $table->decimal('total_price', 10, 2);
            $table->text('special_requests')->nullable();
            $table->string('status')->default('pending'); // pending, confirmed, completed, cancelled
            $table->string('payment_status')->default('unpaid'); // unpaid, paid
            $table->timestamps();
        });

        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('destination_id')->constrained()->onDelete('cascade');
            $table->integer('rating');
            $table->text('comment');
            $table->boolean('is_approved')->default(true);
            $table->timestamps();
        });



        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('cascade');
            $table->string('title');
            $table->text('message');
            $table->string('type')->default('booking'); // booking, chat, system
            $table->boolean('is_read')->default(false);
            $table->timestamps();
        });

        Schema::create('saved_places', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('destination_id')->constrained('destinations')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('saved_places');
        Schema::dropIfExists('notifications');
        Schema::dropIfExists('reviews');
        Schema::dropIfExists('bookings');
        Schema::dropIfExists('tour_packages');
        Schema::dropIfExists('destinations');
        Schema::dropIfExists('categories');
    }
};
