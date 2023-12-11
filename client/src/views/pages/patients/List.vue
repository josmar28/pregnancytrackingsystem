<template>
  <div>
    <b-card no-body>
      <b-card-header class="pb-50">
        <h5>Filters</h5>
      </b-card-header>
      <b-card-body>
        <b-row>
          <b-col cols="12" md="4" class="mt-2">
            <label>Name</label>
            <b-form-input v-model="filters.name.value" trim class="w-100" />
          </b-col>

          <b-col cols="12" md="4" class="mt-2">
            <label for="from_date">{{ $t("From Date") }}</label>
            <b-form-datepicker
              id="from_date"
              :placeholder="$t('Choose a date')"
              :locale="appLocale"
              :direction="appDir"
              v-model="filters.from_date.value"
              :dropup="false"
              no-flip
              class="w-100"
            />
          </b-col>

          <b-col cols="12" md="4" class="mt-2">
            <label for="to_date">{{ $t("To Date") }}</label>
            <b-form-datepicker
              id="to_date"
              :placeholder="$t('Choose a date')"
              :locale="appLocale"
              :direction="appDir"
              v-model="filters.to_date.value"
              :dropup="false"
              no-flip
              class="w-100"
            />
          </b-col>
        </b-row>
      </b-card-body>
    </b-card>

    <list-table
      resource="patients"
      api-path="/api/patients"
      :filters="filters"
      :columns="columns"
      :actions="actions"
    >
      <template #cell(name)="data">
        <b-media vertical-align="center">
          <b-link
            :to="{ name: 'users.edit', params: { id: data.item.id } }"
            class="font-weight-bold d-block text-nowrap"
          >
            {{ data.item.name }}
          </b-link>
          <small class="text-muted">@{{ data.item.username }}</small>
        </b-media>
      </template>
      <template #cell(status)="data">
        <b-badge
          pill
          :variant="`light-${resolveStatusVariant(data.item.status)}`"
          class="text-capitalize"
        >
          {{ data.item.status_value }}
        </b-badge>
      </template>

      <template #custom_dropdown_actions="{ item }">
        <b-dropdown-item
          v-if="item.actions.can_reset_password"
          @click="openResetPasswordModal(item)"
        >
          <feather-icon icon="UnlockIcon" />
          <span class="align-middle ml-50">{{ $t("Reset Password") }}</span>
        </b-dropdown-item>
      </template>
    </list-table>

    <reset-password-modal
      v-model="showResetPasswordModal"
      :user.sync="currentRow"
    ></reset-password-modal>
  </div>
</template>

<script>
import { avatarText } from "@core/utils/filter";
import ListTable from "../../components/ListTable";
import ResetPasswordModal from "../../components/modals/ResetPasswordModal";
import { SET_BREADCRUMB } from "@/store/breadcrumbs.store";
import { resolveStatusVariant } from "@core/mixins/helpers";
import { getRoles } from "@core/comp-functions/roles";

export default {
  components: {
    ListTable,
    ResetPasswordModal,
  },
  data() {
    return {
      actions: {
        view: this.$ability.can("view", "patient"),
        create: this.$ability.can("create", "patient"),
        update: this.$ability.can("update", "patient"),
        delete: this.$ability.can("delete", "patient"),
      },
      filters: {
        name: {
          value: null,
        },
        email: {
          value: null,
        },
        role_id: {
          value: null,
          format() {
            return this.value?.id;
          },
        },
        status: {
          value: null,
          format() {
            return this.value?.value;
          },
        },
        from_date: {
          value: null,
        },
        to_date: {
          value: null,
        },
      },
      showResetPasswordModal: false,
      currentRow: null,
    };
  },
  computed: {
    columns() {
      return [
        { key: "id", label: "ID", sortable: true },
        { key: "first_name", label: "First Name", sortable: true },
        { key: "last_name", label: "Last Name", sortable: true },
        { key: "gender", label: "Gender", sortable: true },
        { key: "contact", label: "Contact Number", sortable: true },
        { key: "actions" },
      ];
    },
  },
  mounted() {
    this.$store.dispatch(SET_BREADCRUMB, [
      { text: this.$t("modules.patients.patients"), active: true },
    ]);
  },
  methods: {
    openResetPasswordModal(row) {
      this.showResetPasswordModal = true;
      this.currentRow = row;
    },
  },
  setup() {
    const { roles } = getRoles();

    return {
      roles,

      // Filter
      avatarText,

      // UI
      resolveStatusVariant,
    };
  },
};
</script>

<style lang="scss" scoped>
.per-page-selector {
  width: 90px;
}
</style>
