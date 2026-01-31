<template>
  <el-main>
    <PropertiesFilters
        v-model="filters"
        @reset="resetFilters"
    />

    <PropertiesTable
        :data="results"
        :loading="loading"
        :pagination="pagination"
        @page-change="handlePageChange"
        @size-change="handlePerPageChange"
        @sort-change="handleSortChange"
    />
  </el-main>
</template>

<script setup>
import {reactive, ref, watch} from 'vue'
import axios from 'axios'
import PropertiesFilters from '@/components/PropertiesFilters.vue'
import PropertiesTable from '@/components/PropertiesTable.vue'

let debounceTimeout
let abortController = null

const loading = ref(false)
const results = ref([])

const filters = ref({
  name: '',
  bedrooms: null,
  bathrooms: null,
  storeys: null,
  garages: null,
  price_min: null,
  price_max: null,
})

const queryParams = ref({
  page: 1,
  per_page: 10,
  sort_by: null,
  sort_order: null,
})

const pagination = ref({
  current_page: 1,
  per_page: 10,
  total: 0,
})

const search = async (page = 1) => {
  loading.value = true
  queryParams.value.page = page

  if (abortController) abortController.abort()
  abortController = new AbortController()

  try {
    const {data} = await axios.get('/api/v1/properties', {
      params: {...filters.value, ...queryParams.value},
      signal: abortController.signal,
    })

    results.value = data.data
    pagination.value = data.meta
  } catch (err) {
    if (axios.isCancel(err)) return // request was aborted
    console.error(err)
  } finally {
    loading.value = false
  }
}

const debouncedSearch = () => {
  clearTimeout(debounceTimeout)
  debounceTimeout = setTimeout(() => search(1), 300)
}

watch(filters, () => {
  debouncedSearch()
})

const handlePageChange = (page) => search(page)

const handlePerPageChange = (size) => {
  queryParams.value.per_page = size
  search(1)
}

const handleSortChange = ({prop, order}) => {
  queryParams.value.sort_by = prop
  queryParams.value.sort_order =
      order === 'ascending' ? 'asc' :
          order === 'descending' ? 'desc' : null
  search(1)
}

const resetFilters = () => {
  filters.value = {
    name: '',
    bedrooms: null,
    bathrooms: null,
    storeys: null,
    garages: null,
    price_min: null,
    price_max: null,
  }

  queryParams.value.page = 1

  // search(1)
}

search()
</script>

<style scoped>
.page {
  background: #f5f7fa;
  min-height: 100vh;
}

.filters-card {
  margin-bottom: 20px;
}

.filters {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
  gap: 12px;
}

.table-card {
  margin-top: 10px;
}

.pagination {
  display: flex;
  justify-content: flex-end;
  margin-top: 20px;
}
</style>