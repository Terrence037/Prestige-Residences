<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Property;
use App\Models\PropertyImage;
use App\Models\Inquiry;
use App\Models\Appointment;
use App\Models\Reservation;
use App\Models\Payment;
use App\Models\Favorite;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 0. Clean slate to avoid duplicate errors on fresh seeds
        Schema::disableForeignKeyConstraints();
        User::truncate();
        Property::truncate();
        PropertyImage::truncate();
        Inquiry::truncate();
        Appointment::truncate();
        Reservation::truncate();
        Payment::truncate();
        Favorite::truncate();
        Schema::enableForeignKeyConstraints();

        // 1. CREATE USERS (Logins preserved as requested)
        $admin = User::create([
            'email' => 'admin@realestate.com',
            'name' => 'System Administrator',
            'password' => Hash::make('admin'),
            'role' => 'admin',
            'phone' => '000-000-0000',
            'profile_image' => 'https://ui-avatars.com/api/?name=Admin&background=dark&color=fff',
        ]);

        $agent1 = User::create([
            'email' => 'agent1@realestate.com',
            'name' => 'Marcus Thorne',
            'password' => Hash::make('password123'),
            'role' => 'agent',
            'phone' => '+1 (555) 723-4921',
            'profile_image' => 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?w=150',
        ]);

        // Added Second Agent
        $agent2 = User::create([
            'email' => 'agent2@realestate.com',
            'name' => 'Sarah Jenkins',
            'password' => Hash::make('password123'),
            'role' => 'agent',
            'phone' => '+1 (555) 892-0032',
            'profile_image' => 'https://images.unsplash.com/photo-1544005313-94ddf0286df2?w=150',
        ]);

        $buyer = User::create([
            'email' => 'buyer@realestate.com',
            'name' => 'Derrick Cole',
            'password' => Hash::make('password123'),
            'role' => 'buyer',
            'phone' => '+1 (555) 438-9201',
            'profile_image' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=150',
        ]);
        Property::create([
            'agent_id' => $agent1->id,
            'title' => 'Ultra-Modern Skyline Penthouse',
            'description' => 'Private elevators and wrap-around terraces in the heart of Manhattan.',
            'property_type' => 'Condo',
            'price' => 880000.00,
            'bedrooms' => 3,
            'bathrooms' => 3.0,
            'floor_area' => 240,
            'lot_area' => 240,
            'address' => '742 Park Avenue, Apt 48B',
            'city' => 'Manhattan',
            'status' => 'available',
            'featured_image' => 'https://images.unsplash.com/photo-1512917774080-9991f1c4c750?auto=format&fit=crop&w=1200&q=80',
        ]);

        // 3. NEW: Austin Suburban Oasis (Agent 2)
        Property::create([
            'agent_id' => $agent2->id,
            'title' => 'Suburban Oasis with Infinity Pool',
            'description' => 'Beautiful family home in a quiet neighborhood with upgraded smart features.',
            'property_type' => 'House',
            'price' => 650000.00,
            'bedrooms' => 4,
            'bathrooms' => 3.5,
            'floor_area' => 310,
            'lot_area' => 500,
            'address' => '442 Oak Street',
            'city' => 'Austin',
            'status' => 'available',
            'featured_image' => 'https://images.unsplash.com/photo-1564013799919-ab600027ffc6?auto=format&fit=crop&w=1200&q=80',
        ]);

        // 4. NEW: Miami Beachfront Studio (Agent 2)
        Property::create([
            'agent_id' => $agent2->id,
            'title' => 'Minimalist Beachfront Studio',
            'description' => 'Step directly onto the sand from this high-end renovated studio.',
            'property_type' => 'Apartment',
            'price' => 420000.00,
            'bedrooms' => 1,
            'bathrooms' => 1.0,
            'floor_area' => 85,
            'lot_area' => 85,
            'address' => '102 Collins Ave',
            'city' => 'Miami',
            'status' => 'available',
            'featured_image' => 'https://images.unsplash.com/photo-1560448204-e02f11c3d0e2?auto=format&fit=crop&w=1200&q=80',
        ]);

        // 5. NEW: Corporate Office Tower (Agent 1)
        Property::create([
            'agent_id' => $agent1->id,
            'title' => 'Metropolitan Corporate Center',
            'description' => 'Prime commercial real estate with high-speed fiber and secure parking.',
            'property_type' => 'Commercial',
            'price' => 4500000.00,
            'bedrooms' => 0,
            'bathrooms' => 10,
            'floor_area' => 1200,
            'lot_area' => 1500,
            'address' => '88 Financial Dist',
            'city' => 'Chicago',
            'status' => 'available',
            'featured_image' => 'https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?auto=format&fit=crop&w=1200&q=80',
        ]);

        // 2. CREATE PROPERTIES
        $p1 = Property::create([
            'agent_id' => $agent1->id,
            'title' => 'The Glass Pavilion & Modern Estates',
            'description' => 'Designed by world-renowned architects, this modern luxury glass villa offers floor-to-ceiling glass walls, sweeping canyon and sky views, and premium security.',
            'property_type' => 'House',
            'price' => 2400000.00,
            'bedrooms' => 5,
            'bathrooms' => 6.0,
            'floor_area' => 580,
            'lot_area' => 1200,
            'address' => '1482 Sunset Plaza Dr',
            'city' => 'Beverly Hills',
            'status' => 'available',
            'featured_image' => 'https://images.unsplash.com/photo-1613490493576-7fde63acd811?auto=format&fit=crop&w=1200&q=80',
        ]);

        $p2 = Property::create([
            'agent_id' => $agent1->id,
            'title' => 'Ultra-Modern Skyline Penthouse',
            'description' => 'Perched high above the city, this breathtaking penthouse features custom skylights, wrap-around terraces, and private elevators.',
            'property_type' => 'Condo',
            'price' => 880000.00,
            'bedrooms' => 3,
            'bathrooms' => 3.0,
            'floor_area' => 240,
            'lot_area' => 240,
            'address' => '742 Park Avenue, Apt 48B',
            'city' => 'Manhattan',
            'status' => 'available',
            'featured_image' => 'https://images.unsplash.com/photo-1512917774080-9991f1c4c750?auto=format&fit=crop&w=1200&q=80',
        ]);

        $p3 = Property::create([
            'agent_id' => $agent2->id,
            'title' => 'Sleek Industrial Loft Downtown',
            'description' => 'Centrally located industrial loft with exposed brickwork, high structural steel framing, and polished concrete floors.',
            'property_type' => 'Apartment',
            'price' => 380000.00,
            'bedrooms' => 1,
            'bathrooms' => 1.5,
            'floor_area' => 125,
            'lot_area' => 125,
            'address' => '410 Folsom St, Unit 302',
            'city' => 'San Francisco',
            'status' => 'reserved',
            'featured_image' => 'https://images.unsplash.com/photo-1600607687939-ce8a6c25118c?auto=format&fit=crop&w=1200&q=80',
        ]);

        // 3. PROPERTY IMAGES
        PropertyImage::create(['property_id' => $p1->id, 'image_path' => 'https://images.unsplash.com/photo-1513694203232-719a280e022f?w=600']);
        PropertyImage::create(['property_id' => $p2->id, 'image_path' => 'https://images.unsplash.com/photo-1502672260266-1c1ef2d93688?w=600']);
        PropertyImage::create(['property_id' => $p3->id, 'image_path' => 'https://images.unsplash.com/photo-1512915922686-57c11dde9b6b?w=600']);

        // 4. INQUIRIES
        Inquiry::create([
            'property_id' => $p1->id,
            'user_id' => $buyer->id,
            'message' => 'Hello! I am highly interested in this Beverly Hills villa.',
            'status' => 'responded',
        ]);

        Inquiry::create([
            'property_id' => $p2->id,
            'user_id' => $buyer->id,
            'message' => 'Does this penthouse include a dedicated parking slot?',
            'status' => 'pending',
        ]);

        // 5. APPOINTMENTS
        Appointment::create([
            'property_id' => $p1->id,
            'buyer_id' => $buyer->id,
            'agent_id' => $agent1->id,
            'appointment_date' => now()->addDays(4),
            'status' => 'approved',
        ]);

        Appointment::create([
            'property_id' => $p3->id,
            'buyer_id' => $buyer->id,
            'agent_id' => $agent2->id,
            'appointment_date' => now()->addDays(2),
            'status' => 'pending',
        ]);

        // 6. RESERVATIONS & PAYMENTS
        // Reservation for P1 (Paid and Verified)
        $res1 = Reservation::create([
            'property_id' => $p1->id,
            'buyer_id' => $buyer->id,
            'reservation_fee' => 10000.00,
            'reservation_status' => 'approved',
            'payment_status' => 'verified',
        ]);

        Payment::create([
            'reservation_id' => $res1->id,
            'buyer_id' => $buyer->id,
            'amount' => 10000.00,
            'payment_method' => 'Bank Wire Transfer',
            'receipt_image' => 'https://images.unsplash.com/photo-1554415707-6e8cfc93fe23?w=500',
            'payment_status' => 'verified',
        ]);

        // Reservation for P3 (Pending Payment)
        $res2 = Reservation::create([
            'property_id' => $p3->id,
            'buyer_id' => $buyer->id,
            'reservation_fee' => 3800.00,
            'reservation_status' => 'pending',
            'payment_status' => 'pending',
        ]);

        // 7. FAVORITES
        Favorite::create(['user_id' => $buyer->id, 'property_id' => $p1->id]);
        Favorite::create(['user_id' => $buyer->id, 'property_id' => $p2->id]);
        Favorite::create(['user_id' => $buyer->id, 'property_id' => $p3->id]);
    }
}