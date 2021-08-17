<template>
  <li class="dropdown notification-list">
    <a
      class="nav-link dropdown-toggle waves-effect"
      data-toggle="dropdown"
      href="javascript:void(0)"
      role="button"
      aria-haspopup="false"
      aria-expanded="false"
    >
      <i class="fe-bell noti-icon"></i>
      <span v-if="unreadCount" class="badge badge-danger rounded-circle noti-icon-badge">{{ unreadCount }}</span>
    </a>
    <div class="dropdown-menu dropdown-menu-right dropdown-lg">
      <!-- item-->
      <div class="dropdown-item noti-title">
        <h5 class="m-0">
          <span class="float-right" v-if="notifications && notifications.length">
            <a href="javascript:void(0)" @click.prevent="clearAll" class="text-dark">
              <span class="small" v-if="clear.loading"><div class="mdi mdi-loading mdi-spin"></div></span>
              <span class="small" v-else>Clear All</span>
            </a>
          </span>
          
          Notification
        </h5>
      </div>
        <div v-if="loading">
            <span class="mdi mdi-loading mdi-spin"></span> Loading notifications
        </div>
      <div v-else-if="notifications && notifications.length">
        <perfect-scrollbar>
          <div class="noti-scroll">
            <!-- item-->
            <a
              v-for="notification in notifications"
              :key="notification.id"
              href="javascript:void(0);"
              @click="markAsRead(notification.id, notification.url)"
              class="dropdown-item notify-item active"
              :disabled="read.loading && read.id === notification.id"
            >
              <div class="notify-icon">
                <img
                  :src="notification.photo"
                  class="img-fluid rounded-circle"
                  alt="Customer Photo"
                />
              </div>
              <p class="notify-details">{{ notification.title }}</p>
              <p class="text-muted mb-0 user-msg">
                <small v-html="notification.message ? notification.message : notification.time"></small>
              </p>
            </a>
          </div>
        </perfect-scrollbar>

        <!-- All-->
        <a
          href="javascript:void(0);"
          class="dropdown-item text-center text-primary notify-item notify-all"
        >
          View all
          <i class="fi-arrow-right"></i>
        </a>
      </div>
      <div class="text-center" v-else>
          No notifications! <a href="">Show all</a>
      </div>
    </div>
  </li>
</template>

<script>
export default {
  name: "Notifications",
  data() {
    return {
      loading: false,
      notifications: [],
      read: {
          selected: null,
          loading: false,
      },
      clear: {
        loading: false,
      }
    };
  },
  computed: {
      unreadCount() {
          if(this.notifications && this.notifications.length) {
              return this.notifications.length;
          }
          return 0;
      }
  },
  methods: {
      fetchNotifications() {
          this.loading = true;

          axios.get(route('admin.notifications.unread'))
          .then(resp => {
              this.notifications = resp.data;
          })
          .catch(err => {
              toastr.error('Unable to load notifications', 'Error')
          })
          .finally(() => this.loading = false)
      },
      markAsRead(id, url) {
          if(id) {
            if(!this.read.loading) {
                axios.post(route('admin.notifications.markAsRead', {notification_id: id}))
                .then(resp => {
                    if(resp.data === true) {
                      const notification = this.notifications.find(noti => noti.id === id)
                      const index = this.notifications.indexOf(notification)

                      if(index > -1) {
                        this.notifications.splice(index, 1)
                      }

                    }

                    if(url) {
                        window.location = url
                    }
                })
                .catch(err => {
                    toastr.error('Unable to open notification', 'Error')
                })
                .finally(() => {
                    this.read.selected = null;
                    this.read.loading = false;
                })
            }
          }

        this.selected.id = id;
        this.read.loading = true;
      },
      clearAll() {
        this.clear.loading = true;
          axios.post(route('admin.notifications.markAllAsRead'))
          .then(resp => {
            this.notifications = []
          })
          .catch(err => {
              
          })
          .finally(() => this.clear.loading = false)
      }
  },
  created() {
      this.fetchNotifications()
  }
};
</script>

<style>
</style>