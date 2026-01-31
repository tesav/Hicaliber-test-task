<template>
  <el-card shadow="hover" class="filters-card">
    <el-form :inline="true" class="filters">
      <el-input
          v-model="localFilters.name"
          placeholder="Name"
          clearable
          @input="emitChange"
      />

      <el-input-number v-model="localFilters.bedrooms" placeholder="Bedrooms" @change="emitChange"/>
      <el-input-number v-model="localFilters.bathrooms" placeholder="Bathrooms" @change="emitChange"/>
      <el-input-number v-model="localFilters.storeys" placeholder="Storeys" @change="emitChange"/>
      <el-input-number v-model="localFilters.garages" placeholder="Garages" @change="emitChange"/>

      <el-input-number v-model="localFilters.price_min" placeholder="Min Price" @change="emitChange"/>
      <el-input-number v-model="localFilters.price_max" placeholder="Max Price" @change="emitChange"/>

      <el-button type="warning" plain @click="reset">
        Reset
      </el-button>
    </el-form>
  </el-card>
</template>

<script setup>
import {reactive, watch} from 'vue'

const props = defineProps({
  modelValue: Object,
})

const emit = defineEmits(['update:modelValue', 'reset'])

const localFilters = reactive({...props.modelValue})

watch(localFilters, () => {
  emit('update:modelValue', {...localFilters})
})

watch(
    () => props.modelValue,
    (newVal) => {
      Object.assign(localFilters, newVal)
    },
    { deep: true }
)

const emitChange = () => {
  emit('update:modelValue', {...localFilters})
}

const reset = () => {
  emit('reset')
}
</script>
