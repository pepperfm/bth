<template>
  <Layout>
    <div class="col-12 ">
      <div class="card shadow-lg">
        <!-- Main container header -->
        <div class="card-header">
          <div class="row">
            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-xs-12">
              <el-button
                type="primary"
                plain
                v-if="$page.props.user.is_admin"
                @click="create()"
              >
                Добавить продукт
              </el-button>
            </div>
            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-xs-12">
              <el-pagination
                class="justify-content-end"
                :current-page="filters.pagination.page"
                :page-size="15"
                :total="total"
                background
                layout="total, prev, pager, next"
                @current-change="handleCurrentChange"
                @size-change="handleSizeChange"
              >
              </el-pagination>
            </div>
          </div>
        </div>

        <div class="card-body table-responsive">
          <table class="table table-responsive table-hover">
            <thead>
            <!-- Column lables -->
              <tr>
                <th
                  class="clickable"
                  @click="sorting('article')"
                >
                  Артикул
                  <em
                    v-if="filters.sort.field === 'article'"
                    :class="{
                      'fas fa-sort-amount-down': !filters.sort.order,
                      'fas fa-sort-amount-up': filters.sort.order,
                    }"
                    class="pull-right fa"
                  ></em>
                </th>
                <th
                  class="clickable"
                  @click="sorting('name')"
                >
                  Название
                  <em
                    v-if="filters.sort.field === 'name'"
                    :class="{
                      'fas fa-sort-amount-down': !filters.sort.order,
                      'fas fa-sort-amount-up': filters.sort.order,
                    }"
                    class="pull-right fa"
                  ></em>
                </th>
                <th
                  class="clickable"
                  @click="sorting('status')"
                >
                  Статус
                  <em
                    v-if="filters.sort.field === 'status'"
                    :class="{
                      'fas fa-sort-amount-down': !filters.sort.order,
                      'fas fa-sort-amount-up': filters.sort.order,
                    }"
                    class="pull-right fa"
                  ></em>
                </th>
                <td>
                  Атрибуты
                </td>
                <td class="text-center">
                  Действия
                </td>
              </tr>
            </thead>
            <!-- Table rendering -->
            <tbody>
              <tr>
                <td>
                  <el-input
                    v-model="filters.fields.article"
                    placeholder="Введите артикул"
                    clearable
                    @input="getRecords()"
                  >
                  </el-input>
                </td>
                <td>
                  <el-input
                    v-model="filters.fields.name"
                    placeholder="Введите имя"
                    clearable
                    @input="getRecords()"
                  >
                  </el-input>
                </td>
                <td>
                  <el-select
                    v-model="filters.fields.status"
                    placeholder="Выберите статус"
                    :clearable="true"
                    @change="getRecords(false)"
                  >
                    <el-option
                      v-for="item in statuses"
                      :key="item.id"
                      :label="item.name"
                      :value="item.id"
                    >
                    </el-option>
                  </el-select>
                </td>
                <td></td>
                <td class="text-center">
                  <el-button
                    type="warning"
                    plain
                    @click="clearFilters"
                  >
                    Сбросить фильтры
                  </el-button>
                </td>
              </tr>
              <tr
                v-for="(product, index) in $page.props.products"
                :key="index"
              >
                <td v-text="product.article"></td>
                <td v-text="product.name"></td>
                <td v-text="product.status_label"></td>
                <td v-text="product.options"></td>
                <td class="actions">
                  <el-button
                    v-if="!product.deleted_at"
                    type="warning"
                    plain
                    icon="Edit"
                    @click="edit(product)"
                  >
                  </el-button>
                  <el-tooltip
                    class="item"
                    effect="dark"
                    content="Удалить продукт"
                    placement="top"
                  >
                    <el-button
                      type="danger"
                      icon="Delete"
                      circle
                      @click="remove(product)"
                    ></el-button>
                  </el-tooltip>
                </td>
              </tr>
            </tbody>

          </table>
        </div>
      </div>
    </div>
  </Layout>
</template>

<script setup lang="ts">
import Layout from "./../Layout/Layout.vue";

import { reactive, ref } from 'vue';
import { ElMessage } from 'element-plus';

import { router } from '@inertiajs/vue3'
import Filter from './Filter.js'

const props = defineProps({
  products: {
    type: Object,
    required: true,
  },
  total: {
    type: Number,
    required: true,
  },
})
const initFilters = JSON.stringify(Filter)
let filters = Filter
let total = props.total
let products = reactive(props.products)
const statuses = ref([
  {id: 'available', name: 'Доступен'},
  {id: 'unavailable', name: 'Не доступен'},
])
const getRecords = (preserveState = true) => {
  router.get('/products', {
    options: filters
  }, {
    preserveState: preserveState
  })
}

products.map((product) => {
  let data = JSON.parse(JSON.stringify(product.options))
  product.options = `color_name: ${data.color_name}, color_value: ${data.color_value}`
})

const create = () => {
  router.visit('/products/create')
}
const edit = (product) => {
  router.visit(`/products/${product.id}`)
}
const remove = (product) => {
  router.delete(`/products/${product.id}`, {
    onSuccess: () => {
      ElMessage({
        message: 'Deleted',
        type: 'success',
      })
      router.visit('/products')
    },
  })
}

const handleCurrentChange = (page) => {
  filters.pagination.page = page
  getRecords(false)
}
const handleSizeChange = (size) => {
  filters.pagination.limit = size
  getRecords(false)
}
const sorting = (field) => {
  filters.sort.field = field
  filters.sort.order = !filters.sort.order
  getRecords(false)
}
const clearFilters = () => {
  router.visit('/products')
}
</script>

<style scoped lang="css">
.clickable {
  cursor: pointer;
}

.search--field {
  padding: 0 !important;
}

.page-link {
  color: #007bff !important;
}

.not-set {
  color: red;
}

.td-heading {
  width: 35%;
}

.td-text {
  width: 65%;
}
.el-date-editor.el-input, .el-date-editor.el-input__inner {
  max-width: 260px !important;
}
.hidden {
  display: none;
}
</style>
