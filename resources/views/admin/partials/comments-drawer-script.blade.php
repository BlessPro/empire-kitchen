
<?php
// =============================================
// resources/views/admin/projects/partials/comments-drawer-script.blade.php
// =============================================
?>
<script>
function projectCommentsDrawer(cfg) {
  return {
    projectId: cfg.projectId,
    routes: cfg.routes,
    badge: 0,
    openDrawer: false,
    loading: false,
    sending: false,
    items: [],
    draft: '',
    meId: {{ auth()->id() }},
    pollTimer: null,

    async init() {
      await this.refreshBadge();
    },

    async open() {
      this.openDrawer = true;
      this.loading = true;
      await this.fetchList();
      this.loading = false;
      await this.markSeen();
      this.badge = 0;
      this.scrollToBottom();
      this.startPolling();
    },
    close() {
      this.openDrawer = false;
      this.stopPolling();
    },

    async refreshBadge() {
      try {
        const r = await fetch(this.routes.unread, { headers: { 'X-Requested-With': 'XMLHttpRequest' }});
        const j = await r.json();
        this.badge = j.unread ?? 0;
      } catch (e) { /* silent */ }
    },

    async fetchList() {
      const url = new URL(this.routes.index, window.location.origin);
      url.searchParams.set('limit', 50);
      const r = await fetch(url, { headers: { 'X-Requested-With': 'XMLHttpRequest' }});
      const j = await r.json();
      this.items = j.data || [];
    },

    async markSeen() {
      try {
        await fetch(this.routes.seen, { method: 'POST', headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content, 'X-Requested-With': 'XMLHttpRequest' }});
      } catch (e) { /* ignore */ }
    },

    async send() {
      const body = this.draft.trim();
      if (!body || this.sending) return;
      this.sending = true;
      try {
        const r = await fetch(this.routes.store, {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content,
            'X-Requested-With': 'XMLHttpRequest',
          },
          body: JSON.stringify({ body })
        });
        if (!r.ok) throw new Error('send failed');
        const j = await r.json();
        if (j && j.data) {
          this.items.push(j.data);
          this.draft = '';
          this.$nextTick(() => this.scrollToBottom());
        }
      } catch (e) {
        alert("Couldn't send. Check your connection and try again.");
      } finally {
        this.sending = false;
      }
    },

    startPolling() {
      this.stopPolling();
      this.pollTimer = setInterval(async () => {
        try {
          if (this.items.length === 0) { await this.fetchList(); return; }
          const latest = this.items[this.items.length - 1]?.created_at;
          if (!latest) return;
          const url = new URL(this.routes.index, window.location.origin);
          url.searchParams.set('after', latest);
          url.searchParams.set('limit', 100);
          const r = await fetch(url, { headers: { 'X-Requested-With': 'XMLHttpRequest' }});
          const j = await r.json();
          if (j && Array.isArray(j.data) && j.data.length) {
            this.items = this.items.concat(j.data);
            this.$nextTick(() => this.scrollToBottom());
            // refresh seen so badge doesn't reappear on close
            await this.markSeen();
          }
        } catch (e) { /* ignore */ }
      }, 12000);
    },

    stopPolling() {
      if (this.pollTimer) clearInterval(this.pollTimer);
      this.pollTimer = null;
    },

    enterToSend(e) {
      // Enter sends, Shift+Enter newline
      if (!e.shiftKey) this.send();
    },

    scrollToBottom() {
      const sc = document.getElementById('commentsScroll');
      if (!sc) return;
      sc.scrollTop = sc.scrollHeight;
    },

    shortTime(iso) {
      try {
        const d = new Date(iso);
        return d.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
      } catch { return ''; }
    },

    placeholder(name) {
      const initials = (name || 'U').split(' ').map(p=>p[0]).slice(0,2).join('').toUpperCase();
      const svg = `<svg xmlns='http://www.w3.org/2000/svg' width='40' height='40'>
        <rect width='100%' height='100%' fill='#e5e7eb'/>
        <text x='50%' y='54%' dominant-baseline='middle' text-anchor='middle' fill='#374151' font-family='Inter, system-ui' font-size='14'>${initials}</text>
      </svg>`;
      return 'data:image/svg+xml;charset=utf-8,' + encodeURIComponent(svg);
    }
  }
}
</script>
