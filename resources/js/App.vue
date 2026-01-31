<template>
  <el-container class="page">
    <properties-page/>
  </el-container>
</template>

<script>
import PropertiesPage from "@/pages/PropertiesPage.vue";

export default {
  components: {PropertiesPage}
}
</script>


<style>
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
