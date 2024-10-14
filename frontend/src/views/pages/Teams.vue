<script setup>
import { CustomerService } from '@/service/CustomerService';
import { FilterMatchMode, FilterOperator } from '@primevue/core/api';
import { onBeforeMount, reactive, ref } from 'vue';


const customers3 = ref(null);
const filters1 = ref(null);
const loading1 = ref(null);
const dropdownVisible = ref(null);
const representatives = reactive([
    { name: 'Amy Elsner', image: 'amyelsner.png' },
    { name: 'Anna Fali', image: 'annafali.png' },
    { name: 'Asiya Javayant', image: 'asiyajavayant.png' },
    { name: 'Bernardo Dominic', image: 'bernardodominic.png' },
    { name: 'Elwin Sharvill', image: 'elwinsharvill.png' },
    { name: 'Ioni Bowcher', image: 'ionibowcher.png' },
    { name: 'Ivan Magalhaes', image: 'ivanmagalhaes.png' },
    { name: 'Onyama Limba', image: 'onyamalimba.png' },
    { name: 'Stephen Shaw', image: 'stephenshaw.png' },
    { name: 'XuXue Feng', image: 'xuxuefeng.png' }
]);

onBeforeMount(() => {
    CustomerService.getCustomersMedium().then((data) => (customers3.value = data));

    initFilters1();
});

function initFilters1() {
    filters1.value = {
        global: { value: null, matchMode: FilterMatchMode.CONTAINS },
        name: { operator: FilterOperator.AND, constraints: [{ value: null, matchMode: FilterMatchMode.STARTS_WITH }] },
        representative: { value: null, matchMode: FilterMatchMode.IN },
        date: { operator: FilterOperator.AND, constraints: [{ value: null, matchMode: FilterMatchMode.DATE_IS }] },
        balance: { operator: FilterOperator.AND, constraints: [{ value: null, matchMode: FilterMatchMode.EQUALS }] },
        status: { operator: FilterOperator.OR, constraints: [{ value: null, matchMode: FilterMatchMode.EQUALS }] },
        activity: { value: [0, 100], matchMode: FilterMatchMode.BETWEEN },
        verified: { value: null, matchMode: FilterMatchMode.EQUALS },
        action: { value: null, matchMode: FilterMatchMode.EQUALS }
    };
}


function formatDate(value) {
    return value.toLocaleDateString('en-US', {
        day: '2-digit',
        month: '2-digit',
        year: 'numeric'
    });
}

function calculateMemberTotal(name) {
    let total = 0;
    if (customers3.value) {
        for (let customer of customers3.value) {
            if (customer.representative.name === name) {
                total++;
            }
        }
    }
    return total;
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
        <div class="font-semibold text-xl mb-4">Teams</div>
        <DataTable :value="customers3" rowGroupMode="subheader" groupRowsBy="representative.name" sortMode="single" sortField="representative.name" :sortOrder="1" scrollable scrollHeight="700px" tableStyle="min-width: 50rem">
            <template #groupheader="slotProps">
                <div class="flex items-center gap-2">
                    <img :alt="slotProps.data.representative.name" :src="`https://primefaces.org/cdn/primevue/images/avatar/${slotProps.data.representative.image}`" width="32" style="vertical-align: middle" />
                    <span>{{ slotProps.data.representative.name }}</span>
                </div>
            </template>
            <Column field="representative.name" header="Representative"></Column>
            <Column field="name" header="Name" style="min-width: 200px"></Column>
            <Column field="date" header="Date" style="min-width: 200px">asd</Column>
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
                                    Move to other team
                                </button>
                            </li>
                            <li>
                                <button class="block w-full px-4 py-2 text-left text-sm" @click="onAction('Unassign')">
                                    Unassign
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
            <template #groupfooter="slotProps">
                <div class="flex justify-end font-bold w-full">Total Members: {{ calculateMemberTotal(slotProps.data.representative.name) }}</div>
            </template>
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
