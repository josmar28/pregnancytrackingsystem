<template>
  <validation-observer ref="form">
    <b-form ref="formRef" @submit.prevent="submit">
      <b-row>
        <b-col cols="12" xl="12">
          <b-card>
            <b-row>
              <b-col cols="6">
                <b-form-group :label="$t('First Name')" label-for="first_name">
                  <validation-provider
                    #default="{ errors }"
                    name="First Name"
                    rules="required"
                  >
                    <b-form-input
                      id="first_name"
                      v-model="form.first_name"
                      :state="errors.length > 0 ? false : null"
                      :placeholder="$t('First Name')"
                    />
                    <small class="text-danger">{{ errors[0] }}</small>
                  </validation-provider>
                </b-form-group>
              </b-col>

              <b-col cols="6">
                <b-form-group :label="$t('Last Name')" label-for="last_name">
                  <validation-provider
                    #default="{ errors }"
                    name="Last Name"
                    rules="required"
                  >
                    <b-input-group
                      class="input-group-merge"
                      :class="errors.length > 0 ? 'is-invalid' : ''"
                    >
                      <b-input-group-prepend is-text>
                        <feather-icon icon="MailIcon" />
                      </b-input-group-prepend>
                      <b-form-input
                        id="last_name"
                        v-model="form.last_name"
                        :state="errors.length > 0 ? false : null"
                        :placeholder="$t('Last Name')"
                      />
                    </b-input-group>
                    <small class="text-danger">{{ errors[0] }}</small>
                  </validation-provider>
                </b-form-group>
              </b-col>

              <b-col cols="6">
                <b-form-group :label="$t('Gender')" label-for="gender">
                  <validation-provider
                    #default="{ errors }"
                    name="gender"
                    vid="gender"
                    rules="required"
                  >
                    <b-form-radio
                      v-model="form.gender"
                      name="gender"
                      value="male"
                      >Male</b-form-radio
                    >
                    <b-form-radio
                      v-model="form.gender"
                      name="gender"
                      value="female"
                      >Female</b-form-radio
                    >
                    <small class="text-danger">{{ errors[0] }}</small>
                  </validation-provider>
                </b-form-group>
              </b-col>

              <b-col cols="6">
                <b-form-group :label="$t('Status')" label-for="status">
                  <validation-provider
                    #default="{ errors }"
                    name="status"
                    vid="status"
                    rules="required"
                  >
                    <b-form-radio
                      v-model="form.status"
                      name="status"
                      value="active"
                      >Active</b-form-radio
                    >
                    <b-form-radio
                      v-model="form.status"
                      name="status"
                      value="inactive"
                      >Inactive</b-form-radio
                    >
                    <small class="text-danger">{{ errors[0] }}</small>
                  </validation-provider>
                </b-form-group>
              </b-col>
              <!-- mobile -->
              <b-col cols="6">
                <b-form-group label-for="contact" :label="$t('Contact')">
                  <validation-provider
                    #default="{ errors }"
                    name="contact"
                    rules="required"
                    vid="contact"
                  >
                    <Mobile v-model="form.contact" :errors="errors" />

                    <small class="text-danger">{{ errors[0] }}</small>
                  </validation-provider>
                </b-form-group>
              </b-col>
            </b-row>

            <b-row class="mb-12">
              <b-col class="d-flex flex-row-reverse">
                <b-button variant="outline-secondary">
                  {{ $t("Cancel") }}
                </b-button>

                <b-button
                  class="mr-1"
                  variant="primary"
                  type="submit"
                  :disabled="processing"
                  v-ripple.400="'rgba(255, 255, 255, 0.15)'"
                >
                  <b-spinner v-if="processing" small type="grow" />

                  {{ $t("Save") }}
                </b-button>
              </b-col>
            </b-row>
          </b-card>
        </b-col>
      </b-row>
    </b-form>
  </validation-observer>
</template>

<script>
import Ripple from "vue-ripple-directive";
import FileUploader from "@/views/components/FileUploader";
import { SET_BREADCRUMB } from "@/store/breadcrumbs.store";
import Mobile from "@/views/components/Mobile";
import { getRoles } from "@core/comp-functions/roles";

export default {
  components: {
    FileUploader,
    Mobile,
  },
  directives: {
    Ripple,
  },
  data() {
    return {
      form: {
        first_name: null,
        last_name: null,
        contact: null,
        gender: null,
        status: null,
      },
      id: this.$route.params.id,
      processing: false,
    };
  },
  methods: {
    submit() {
      this.processing = true;

      this.$refs.form
        .validate()
        .then((success) => {
          if (success) {
            this.$http[this.id ? "put" : "post"](
              "/api/histories" + (this.id ? `/${this.id}` : ""),
              this.form
            )
              .then(({ data }) => {
                this.softToast(
                  "success",
                  this.$t("Success"),
                  data.message,
                  "CheckIcon"
                );
                this.$router.push({ name: "histories.index" });
              })
              .catch((error) =>
                this.handleResponseError(error, this.$refs.form)
              )
              .finally(() => {
                this.processing = false;
              });
          } else {
            this.processing = false;
          }
        })
        .catch(() => {
          this.processing = false;
        });
    },
  },
  created() {
    if (this.id) {
      this.$http
        .get(`/api/histories/${this.id}`)
        .then((response) => {
          const data = response.data.data;
          this.$nextTick(() => {
            this.form = {
              first_name: data.first_name,
              last_name: data.last_name,
              contact: data.contact,
              gender: data.gender,
              status: data.status,
            };
          });
        })
        .catch(this.handleResponseError);
    }
  },
  mounted() {
    this.$store.dispatch(SET_BREADCRUMB, [
      {
        text: this.$t("modules.histories.histories"),
        to: { name: "histories.index" },
      },
      {
        text: this.id
          ? this.$t("modules.histories.edit")
          : this.$t("modules.histories.create"),
        active: true,
      },
    ]);
  },
  setup() {
    const { roles } = getRoles();

    return {
      roles,
    };
  },
};
</script>
