<script setup>
import { reactive, ref } from 'vue';
import { FilterMatchMode, FilterOperator } from '@primevue/core/api';
import axios from 'axios';

// State variables
const parts = ref(null);
const filters = ref(null);
const loading = ref(true);
const dropdownVisible = ref(null);
const statuses = reactive(['unqualified', 'qualified', 'new', 'negotiation', 'renewal', 'proposal']);

const fetchParts = async () => {
  try {
    const response = await axios.get('http://localhost:8000/api/system-wide-parts');
    parts.value = response.data;
  } catch (error) {
    console.error('Error during data fetching: ', error);
  } finally {
    loading.value = false;
  }
};

fetchParts();

// Initialize filters
function initFilters() {
    filters.value = {
        global: { value: null, matchMode: FilterMatchMode.CONTAINS },
        'model_number': { operator: FilterOperator.AND, constraints: [{ value: null, matchMode: FilterMatchMode.STARTS_WITH }] },
        'manufacturer.name': { operator: FilterOperator.AND, constraints: [{ value: null, matchMode: FilterMatchMode.STARTS_WITH }] },
        'part_type.name': { operator: FilterOperator.AND, constraints: [{ value: null, matchMode: FilterMatchMode.STARTS_WITH }] },
    };
}

// Initialize filters immediately
initFilters();

// Helper functions
function formatCurrency(value) {
    return value.toLocaleString('en-US', { style: 'currency', currency: 'USD' });
}

function formatDate(value) {
    return value ? value.toLocaleDateString('en-US', {
        day: '2-digit',
        month: '2-digit',
        year: 'numeric'
    }) : '-';
}
function onAction(action) {
  alert(`You selected ${action}`);
  dropdownVisible.value = false;
}
function toggleDropdown(id) {
  if (dropdownVisible.value === id) {
    dropdownVisible.value = null;
  } else {
    dropdownVisible.value = id;
  }
}
function closeDropdown() {
  dropdownVisible.value = null;
}
</script>

<template>
    <div class="card">
        <div class="font-semibold text-xl mb-4">System-Wide Parts</div>
        <DataTable
            :value="parts"
            :paginator="true"
            :rows="10"
            dataKey="id"
            :rowHover="true"
            v-model:filters="filters"
            filterDisplay="menu"
            :loading="loading"
            :filters="filters"
            :globalFilterFields="['model_number', 'manufacturer.name', 'part_type.name']"
            showGridlines
            scrollable
            scrollHeight="800px" 
        >
            <template #header>
                <div class="flex justify-between">
                    <IconField>
                        <InputIcon>
                            <i class="pi pi-search" />
                        </InputIcon>
                        <InputText v-model="filters.global.value" placeholder="Keyword Search" />
                    </IconField>
                </div>
            </template>
            <template #empty> No parts found. </template>
            <template #loading> Loading parts data. Please wait. </template>
            <Column field="model_number" header="Model Number" style="min-width: 12rem" />
            <Column field="list_price" header="List Price" style="min-width: 12rem">
                <template #body="{ data }">
                    {{ formatCurrency(data.list_price) }}
                </template>
            </Column>
            <Column field="active" header="Active" style="min-width: 12rem">
                <template #body="{ data }">
                    {{ data.active === 'Y' ? 'Yes' : 'No' }}
                </template>
            </Column>
            <Column field="manufacturer.name" header="Manufacturer" style="min-width: 12rem" />
            <Column field="part_type.name" header="Part Type" style="min-width: 12rem" />
            <Column field="action" header="Action" style="min-width: 200px">
                <template #body="slotProps">
                    <div class="relative inline-block text-left">
                        <button
                        @click="toggleDropdown(slotProps.data.id)"
                        class="p-button p-component p-button-icon-only p-button-rounded p-button-outlined">
                        <span class="p-button-icon pi pi-cog"></span>
                        </button>

                        <!-- Dropdown Menu -->
                        <div
                        v-if="dropdownVisible === slotProps.data.id"
                        class="absolute right-0 mt-2 w-48 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 tableDropdown"
                        @click.away="closeDropdown">
                        <ul class="py-1">
                            <li>
                                <button class="block w-full px-4 py-2 text-left text-sm" @click="onAction('Move')">
                                    Associate to Team
                                </button>
                            </li>
                            <li>
                                <button class="block w-full px-4 py-2 text-left text-sm" @click="onAction('Unassign')">
                                    Edit
                                </button>
                            </li>
                            <li>
                                <button class="block w-full px-4 py-2 text-left text-sm" @click="onAction('Delete')">
                                    Delete
                                </button>
                            </li>
                            
                        </ul>
                        </div>
                    </div>
                    </template>

            </Column>
        </DataTable>
    </div>
</template>

<style scoped lang="scss">
    :deep(.p-datatable-frozen-tbody) {
        font-weight: bold;
    }

    :deep(.p-datatable-scrollable .p-frozen-column) {
        font-weight: bold;
    }
    .tableDropdown {
        z-index: 3;
    }
</style>
