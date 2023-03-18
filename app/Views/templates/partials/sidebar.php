<!-- Sidebar Start -->
<div class="sidebar pe-4 pb-3">
            <nav class="navbar bg-light navbar-light">
                <a href="#" class="navbar-brand mx-4 mb-3">
                <img src="#" width="150" alt="">
                </a>
                <div class="navbar-nav w-100">
                    <a href="/dashboard" class="nav-item nav-link <?= isset($active)&&$active=='dashboard'?'active':''?>"><i class="fa fa-tachometer-alt me-2"></i>Dashboard</a>
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle  <?= isset($active)&&$active=='inwards'?'active':''?>" data-bs-toggle="dropdown"><i class="fas fa-truck-loading me-2"></i>Inwards</a>
                        <div class="dropdown-menu bg-transparent border-0">
                            <a href="/inwards/rom" class="dropdown-item">ROM</a>
                            <a href="/inwards/ob" class="dropdown-item">Over Budden</a>
                        </div>
                    </div>
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle <?= isset($active)&&$active=='production'?'active':''?>" data-bs-toggle="dropdown"><i class="fab fa-bitbucket me-2"></i>Production</a>
                        <div class="dropdown-menu bg-transparent border-0">
                            <a href="/production/crusher" class="dropdown-item">Crusher</a>
                            <a href="/production/screen" class="dropdown-item">Screen</a>
                            <a href="/production/chute" class="dropdown-item">Chute</a>
                            <a href="/production/tantra" class="dropdown-item">Tantra</a>
                            <a href="/production/mines" class="dropdown-item">Mines</a>
                        </div>
                    </div>
                    <a href="/client-info" class="nav-item nav-link <?= isset($active)&&$active=='clientInfo'?'active':''?>"><i class="fas fa-users"></i>Client Info</a>
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle <?= isset($active)&&$active=='dispatch'?'active':''?>" data-bs-toggle="dropdown"><i class="fa fa-truck me-2"></i>Dispatch</a>
                        <div class="dropdown-menu bg-transparent border-0">
                            <a href="/dispatch/ship-info" class="dropdown-item">Ship Info</a>
                            <a href="/dispatch/challan" class="dropdown-item">Challan</a>
                        </div>
                    </div>
                    <a href="/return" class="nav-item nav-link <?=isset($active)&&$active=='return'?'active':''?>"><i class="fas fa-calendar-alt"></i>Return</a>
                    <?php 
                        if(isset($role)&&($role=='admin' || $role=='viewer')){?>
                        <a href="#" class="nav-item nav-link <?=isset($active)&&$active=='monitoring'?'active':'' ?>"><i class='fa fa-laptop me-2'></i>Monitoring</a>
                    <?php } ?>
                    <a href="#" class="nav-item nav-link <?= isset($active)&&$active=='about'?'active':''?>"><i class="fas fa-info-circle"></i>About</a>
                </div>
            </nav>
        </div>
        <!-- Sidebar End -->
