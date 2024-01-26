<template>
  <b-modal
    ref="modal"
    :title="$t('Patient Lists')"
    button-size="sm"
    size="xl"
    ok-only
    ok-variant="secondary"
    ok-title="Cancel"
  >
    <template #modal-ok>
      <b-spinner v-if="processing" small type="grow" />
      {{ $t("Cancel") }}
    </template>

    <validation-observer ref="form">
      <b-form ref="formRef">
        <b-col cols="12" md="4" class="mt-2">
          <label>Name</label>
          <b-form-input v-model="filters.name.value" trim class="w-100" />
        </b-col>
        <modal-table
          resource="histories"
          api-path="/api/histories"
          :filters="filters"
          :columns="columns"
        >
        </modal-table>
      </b-form>
    </validation-observer>
  </b-modal>
</template>

<script>
import ModalTable from "../../components/ModalTable";

export default {
  name: "patient-list-modal",
  components: {
    ModalTable,
  },
  props: {
    user: {
      type: Object,
    },
    value: {
      default() {
        return false;
      },
    },
  },
  data() {
    return {
      selectMode: "single", // or 'multiple' based on your requirement
      selectedRows: [], // To store selected rows
      form: {
        password: null,
        password_confirmation: null,
      },
      processing: false,
      internalValue: false,
      passwordFieldTypeNew: "password",
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
    };
  },
  methods: {},
  computed: {
    columns() {
      return [
        { key: "first_name", label: "First Name", sortable: true },
        { key: "last_name", label: "Last Name", sortable: true },
        { key: "gender", label: "Gender", sortable: true },
        { key: "contact", label: "Contact Number", sortable: true },
        { key: "status", label: "Status", sortable: true },
        { key: "created_at", label: "Created at", sortable: true },
      ];
    },
    tbodyTrClass() {
      return (row, index) => {
        // Check if the current row is in the selectedRows array
        return this.selectedRows.some(
          (selectedRow) => selectedRow.id === row.id
        )
          ? "highlighted-row"
          : ""; // You can replace 'highlighted-row' with your desired CSS class
      };
    },
  },
  watch: {
    value(val) {
      this.internalValue = val;
    },
    internalValue: {
      handler(val) {
        if (val) {
          this.$refs.modal.show();
        } else {
          this.$refs.modal.hide();
        }

        this.$emit("input", val);
      },
    },
  },
};
</script>
