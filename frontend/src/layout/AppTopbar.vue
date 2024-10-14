<script setup>
import { useLayout } from '@/layout/composables/layout';
import AppConfigurator from './AppConfigurator.vue';

const { onMenuToggle, toggleDarkMode, isDarkTheme } = useLayout();
</script>

<template>
    <div class="layout-topbar">
        <div class="layout-topbar-logo-container">
            <button class="layout-menu-button layout-topbar-action" @click="onMenuToggle">
                <i class="pi pi-bars"></i>
            </button>
            <router-link to="/" class="layout-topbar-logo">
                <span>Laravel + Vue</span>
            </router-link>
        </div>

        <div class="layout-topbar-actions">


            <div class="layout-topbar-menu hidden lg:block">
                <div class="layout-topbar-menu-content">
                    <a href="/logout/">
                        <button type="button" class="layout-topbar-action">
                            <i class="pi pi-power-off"></i>
                            <span>Logout</span>
                        </button>
                    </a>
                </div>
            </div>
        </div>
    </div>
</template>
