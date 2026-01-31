<template>
  <el-card shadow="never" class="table-card">
    <el-table
        v-loading="loading"
        :data="data"
        stripe
        highlight-current-row
        @sort-change="$emit('sort-change', $event)"
    >
      <el-table-column prop="name" label="Name" sortable="custom"/>
      <el-table-column prop="bedrooms" label="Bedrooms" sortable="custom" width="110"/>
      <el-table-column prop="bathrooms" label="Bathrooms" sortable="custom" width="120"/>
      <el-table-column prop="storeys" label="Storeys" sortable="custom" width="100"/>
      <el-table-column prop="garages" label="Garages" sortable="custom" width="100"/>
      <el-table-column prop="price" label="Price" sortable="custom"/>
    </el-table>

    <el-empty
        v-if="!loading && data.length === 0"
        description="No results found"
    />

    <div class="pagination">
      <el-pagination
          v-if="pagination.total > 0"
          background
          layout="sizes, prev, pager, next"
          :current-page="pagination.current_page"
          :page-size="pagination.per_page"
          :page-sizes="[5, 10, 20, 50]"
          :total="pagination.total"
          @current-change="$emit('page-change', $event)"
          @size-change="$emit('size-change', $event)"
      />
    </div>
  </el-card>
</template>

<script setup>
defineProps({
  data: Array,
  loading: Boolean,
  pagination: Object,
})

defineEmits(['page-change', 'size-change', 'sort-change'])
</script>
