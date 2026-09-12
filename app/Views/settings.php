 <!-- Control Sidebar -->
<?php helper('getState'); ?>
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Create the tabs -->
    <ul class="nav nav-tabs nav-justified control-sidebar-tabs">
      <li><a href="#control-sidebar-home-tab" data-toggle="tab"><i class=""></i></a></li>
      <li><a href="#control-sidebar-settings-tab" data-toggle="tab"><i class=""></i></a></li>
    </ul>
    
    <!-- Tab panes -->
    <div class="tab-content">
     
      <!-- Home tab content -->
      <div class="tab-pane disabled" id="control-sidebar-home-tab">
        
        <ul class="control-sidebar-menu">
        <h4 class="control-sidebar-heading">Layout Options</h4>

          <div class="form-group"><label class="control-sidebar-subheading"><input type="checkbox" data-layout="fixed" id="layout-fixed-toggle" class="pull-right" <?= getState('fixed-layout') ? 'checked' : '' ?>/> Fixed layout</label>
          <p>Activate the fixed layout. You can\'t use fixed and boxed layouts together</p>
          </div>

          <div class="form-group"><label class="control-sidebar-subheading"><input type="checkbox" data-layout="boxed" id="layout-boxed-toggle" class="pull-right" <?= getState('boxed-layout') ? 'checked' : '' ?>/> Boxed layout</label>
          <p>Activate the boxed layout. You can\'t use fixed and boxed layouts together</p>
          </div>
        
          </ul>
        
          <!-- </li>
        </ul> -->
      </div>

    </div>
  </aside>

  
  <script>
  (function () {
    var saveUrl   = '<?= base_url('layoutsettings/save') ?>';
    var storageKey = 'ci_layout_state_<?= session()->get('user_id'); ?>';

    // Server-rendered baseline (from the session via getState)
    var srv = {
      fixed: <?= getState('fixed-layout') ? 1 : 0 ?>,
      boxed: <?= getState('boxed-layout') ? 1 : 0 ?>,
      collapse: <?= getState('sidebar-collapse') ? 1 : 0 ?>,
      controlSlide: <?= getState('control-sidebar-slide') ? 1 : 0 ?>
    };

    function readLocal() {
      try {
        var raw = localStorage.getItem(storageKey);
        return raw ? JSON.parse(raw) : null;
      } catch (e) { return null; }
    }
    function writeLocal(state) {
      try {
        localStorage.setItem(storageKey, JSON.stringify({
          fixed: state.fixed ? 1 : 0,
          boxed: state.boxed ? 1 : 0,
          collapse: state.collapse ? 1 : 0,
          controlSlide: state.controlSlide ? 1 : 0
        }));
      } catch (e) {}
    }

    function persist(key, value) {
      var body = 'key=' + encodeURIComponent(key) + '&value=' + value;
      var xhr = new XMLHttpRequest();
      xhr.open('POST', saveUrl, true);
      xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
      xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
      xhr.send(body);
    }
    function saveNow(state) {
      persist('fixed-layout', state.fixed ? 1 : 0);
      persist('boxed-layout', state.boxed ? 1 : 0);
      persist('sidebar-collapse', state.collapse ? 1 : 0);
      persist('control-sidebar-slide', state.controlSlide ? 1 : 0);
    }

    function layoutCheckboxes(attr) {
      return document.querySelectorAll('[data-layout="' + attr + '"]');
    }

    // The <body> classes are the source of truth; AdminLTE's demo.js toggles
    // them when any layout checkbox (ours or its injected copies) is changed.
    function readBodyState() {
      return {
        fixed: document.body.classList.contains('fixed') ? 1 : 0,
        boxed: document.body.classList.contains('layout-boxed') ? 1 : 0,
        collapse: document.body.classList.contains('sidebar-collapse') ? 1 : 0
      };
    }

    // Read the current state from the checkboxes (some are injected later by
    // demo.js at document-ready, so the server session is the reliable seed).
    function readCheckboxState() {
      var f = layoutCheckboxes('fixed')[0];
      var b = layoutCheckboxes('layout-boxed')[0];
      var s = layoutCheckboxes('sidebar-collapse')[0];
      return {
        fixed: f && f.checked ? 1 : 0,
        boxed: b && b.checked ? 1 : 0,
        collapse: s && s.checked ? 1 : 0
      };
    }

    // Keep every fixed/boxed/sidebar-collapse checkbox in sync.
    function syncCheckboxes(state) {
      layoutCheckboxes('fixed').forEach(function (cb) { cb.checked = !!state.fixed; });
      layoutCheckboxes('layout-boxed').forEach(function (cb) { cb.checked = !!state.boxed; });
      layoutCheckboxes('sidebar-collapse').forEach(function (cb) { cb.checked = !!state.collapse; });
    }

    // Apply the layout classes to the body
    function applyLayout(state) {
      document.body.classList.toggle('fixed', !!state.fixed);
      document.body.classList.toggle('layout-boxed', !!state.boxed);
      document.body.classList.toggle('sidebar-collapse', !!state.collapse);
    }

    // Apply the "Toggle Right Sidebar Slide" state: checked = push (slide off).
    function applyControlSidebar(state) {
      document.querySelectorAll('[data-controlsidebar="control-sidebar-open"]')
        .forEach(function (cb) { cb.checked = !!state.controlSlide; });
      if (typeof window.jQuery === 'undefined') {
        return;
      }
      var cs = window.jQuery('[data-toggle="control-sidebar"]').data('lte.controlsidebar');
      if (cs) {
        cs.options.slide = !state.controlSlide;
      }
    }

    // Initial state: server session (getState) is the reliable baseline, then
    // local state overrides it if a previous save was aborted by navigation.
    var state = { fixed: srv.fixed, boxed: srv.boxed, collapse: srv.collapse, controlSlide: srv.controlSlide };
    var local = readLocal();
    if (local) {
      if (typeof local.fixed !== 'undefined') state.fixed = local.fixed ? 1 : 0;
      if (typeof local.boxed !== 'undefined') state.boxed = local.boxed ? 1 : 0;
      if (typeof local.collapse !== 'undefined') state.collapse = local.collapse ? 1 : 0;
      if (typeof local.controlSlide !== 'undefined') state.controlSlide = local.controlSlide ? 1 : 0;
    }

    applyLayout(state);
    syncCheckboxes(state);
    applyControlSidebar(state);
    writeLocal(state);

    // If the locally stored state differs from what the server session had
    // (e.g. a save was aborted by navigating away), push it again so the
    // session catches up and matches what is now shown on this page.
    if (state.fixed !== srv.fixed || state.boxed !== srv.boxed || state.collapse !== srv.collapse || state.controlSlide !== srv.controlSlide) {
      saveNow(state);
      writeLocal(state);
    }

    // React to ANY fixed/boxed/sidebar-collapse/control-sidebar checkbox change
    // anywhere in the control sidebar (ours and demo.js's copies). This
    // guarantees an uncheck is persisted and removes the session value, even if
    // demo.js fails to fire.
    document.addEventListener('change', function (ev) {
      var t = ev.target;
      var getAttr = function (n) { return t && t.getAttribute ? t.getAttribute(n) : null; };
      var dl = getAttr('data-layout');
      var cd = getAttr('data-controlsidebar');

      if (dl === 'fixed' || dl === 'layout-boxed' || dl === 'sidebar-collapse') {
        var st = readBodyState();
        st.controlSlide = state.controlSlide;
        applyLayout(st);
        syncCheckboxes(st);
        writeLocal(st);       // immediate - survives navigation even if the POST doesn't
        saveNow(st);          // best-effort push / delete to the server session
      } else if (cd === 'control-sidebar-open') {
        state.controlSlide = t.checked ? 1 : 0;
        applyControlSidebar(state);
        writeLocal(state);
        saveNow(state);
      }
    });
  })();
  </script>
      <!-- /.tab-pane -->
      <!-- Stats tab content -->
