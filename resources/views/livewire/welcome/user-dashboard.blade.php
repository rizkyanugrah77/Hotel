<div class="space-y-6 sm:space-y-8">

    <!-- ===================================
       SECTION 1: Welcome Header
       =================================== -->
    <section class="animate-fade-in-up delay-1" id="welcome-header">
        @include('livewire.welcome.user-dashboard.header')
    </section>


    <!-- ===================================
       SECTION 2: Notifikasi Check-in
       =================================== -->
    @if ($upcomingCheckins->count() > 0)
        <section class="animate-fade-in-up delay-2" id="checkin-alerts">
            @include('livewire.welcome.user-dashboard.notification')
        </section>
    @endif


    <!-- ===================================
       SECTION 3: KPI Cards
       =================================== -->
    <section class="animate-fade-in-up delay-3" id="kpi-cards">
        <!-- Horizontal scroll on mobile, grid on larger screens -->
        @include('livewire.welcome.user-dashboard.kpi-card')
    </section>


    <!-- ===================================
       SECTION 4: Active Bookings + Quick Actions
       =================================== -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 sm:gap-8">


        <!-- Active Bookings (2/3 width on desktop) -->
        @include('livewire.welcome.user-dashboard.active-booking')

        <!-- Quick Actions + Profile (1/3 width on desktop) -->
        @include('livewire.welcome.user-dashboard.quick-action')
    </div>


    <!-- ===================================
       SECTION 5: Booking History
       =================================== -->
    <section class="animate-fade-in-up delay-6" id="booking-history">
        @include('livewire.welcome.user-dashboard.booking-history')
    </section>

</div>
