// exams/js/exam.js
document.addEventListener('DOMContentLoaded', function () {
  // configuration
  var perPage = 5;

  // DOM references
  var items = Array.prototype.slice.call(document.querySelectorAll('.question-item'));
  var total = items.length || 0;
  var totalPages = Math.max(1, Math.ceil(total / perPage));
  var currentPage = 1;

  var btnPrev = document.getElementById('btnPrev');
  var btnNext = document.getElementById('btnNext');
  var btnSubmit = document.getElementById('btnSubmit');
  var reviewBtn = document.getElementById('reviewBtn');

  // state - once review is enabled it should stay enabled permanently
  var reviewPermanentlyEnabled = false;

  // show a given page (1-based)
  function showPage(page) {
    if (!page || page < 1) page = 1;
    if (page > totalPages) page = totalPages;
    currentPage = page;

    var start = (page - 1) * perPage + 1;
    var end = Math.min(page * perPage, total);

    // show items for page, hide others
    for (var i = 0; i < total; i++) {
      var idx = i + 1;
      items[i].style.display = (idx >= start && idx <= end) ? 'block' : 'none';
    }

    // control visibility for prev/next/submit
    if (btnPrev) btnPrev.style.display = (page > 1) ? 'block' : 'none';
    if (btnNext) btnNext.style.display = (page < totalPages) ? 'block' : 'none';
    if (btnSubmit) btnSubmit.style.display = (page < totalPages) ? 'none' : 'inline-block';
    
    // open the first collapse on the page for UX
    setTimeout(function () {
      // find first visible .question-item on the page
      var firstVisible = null;
      for (var i = 0; i < items.length; i++) {
        if (window.getComputedStyle(items[i]).display !== 'none') {
          firstVisible = items[i];
          break;
        }
      }
      if (firstVisible) {
        var firstCollapse = firstVisible.querySelector('.collapse');
        if (firstCollapse && !firstCollapse.classList.contains('show')) {
          try { $(firstCollapse).collapse('show'); } catch (e) { firstCollapse.classList.add('show'); }
        }
      }
    }, 60);

    // scroll top for stable UI
    window.scrollTo({ top: 0, behavior: 'smooth' });

    // review enabling logic
    if (!reviewPermanentlyEnabled) {
      // review should be enabled when (a) on last page AND (b) at least one of last 5 answered
      if (page === totalPages && isAnyOfLastFiveAnswered()) {
        reviewPermanentlyEnabled = true;
        enableReview();
      } else {
        disableReview();
      }
    } else {
      // if already permanently enabled, ensure UI shows enabled state
      enableReview();
    }
  }

  // navigate to a specific question index
  function gotoQuestion(qIndex) {
    if (!qIndex || isNaN(qIndex)) return;
    var targetPage = Math.ceil(qIndex / perPage);
    showPage(targetPage);

    // open that question accordion
    var target = document.getElementById('faq' + qIndex);
    if (target) {
      try {
        $('.collapse.show').collapse('hide');
        $(target).collapse('show');
      } catch (e) {
        // fallback: adjust classes
        document.querySelectorAll('.collapse').forEach(function (c) { c.classList.remove('show'); });
        target.classList.add('show');
      }
      // scroll card into view
      var card = document.getElementById('q' + qIndex);
      if (card) card.scrollIntoView({ behavior: 'smooth', block: 'start' });
    }
  }

  // mark a question as answered (update footer nav)
  function markAnswered(qIndex) {
    var red = document.querySelector('.not-answered-' + qIndex);
    if (red) red.style.display = 'none';
    var green = document.querySelector('.answered-' + qIndex);
    if (green) green.style.display = 'inline-block';
  }

  // check if at least one of last five questions answered
  function isAnyOfLastFiveAnswered() {
    var lastStart = Math.max(1, total - 4); // e.g., total=20 -> 16..20
    for (var i = lastStart; i <= total; i++) {
      var green = document.querySelector('.answered-' + i);
      if (green) {
        var d = window.getComputedStyle(green).display;
        if (d !== 'none') return true;
      }
    }
    return false;
  }

  // enable/disable review
  function enableReview() {
    if (!reviewBtn) return;
    reviewBtn.classList.remove('disabled-link');
    reviewBtn.style.pointerEvents = 'auto';
    reviewBtn.style.opacity = '1';
  }
  function disableReview() {
    if (!reviewBtn) return;
    reviewBtn.classList.add('disabled-link');
    reviewBtn.style.pointerEvents = 'none';
    reviewBtn.style.opacity = '0.5';
  }

  // attach click handlers for prev/next
  if (btnPrev) btnPrev.addEventListener('click', function () {
    if (currentPage > 1) showPage(currentPage - 1);
  });
  if (btnNext) btnNext.addEventListener('click', function () {
    if (currentPage < totalPages) showPage(currentPage + 1);
  });

  // attach answer nav click handlers
  function attachAnswerNavClicks() {
    var navBtns = document.querySelectorAll('.btn-answered, .btn-not-answered');
    navBtns.forEach(function (btn) {
      btn.addEventListener('click', function (e) {
        var qIndex = parseInt(this.getAttribute('data-qindex'), 10);
        if (!isNaN(qIndex)) gotoQuestion(qIndex);
      });
    });
  }

  // attach radio inputs handlers
  function attachAnswerRadios() {
    var radios = document.querySelectorAll('.answer-radio');
    radios.forEach(function (el) {
      el.addEventListener('change', function () {
        var qIndex = this.getAttribute('data-qindex');
        if (qIndex) markAnswered(qIndex);

        // If this question is one of the last five and user is on last page, enable review permanently
        var lastStart = Math.max(1, total - 4);
        var qNum = parseInt(qIndex, 10);
        if (!isNaN(qNum) && qNum >= lastStart) {
          if (currentPage === totalPages && !reviewPermanentlyEnabled && isAnyOfLastFiveAnswered()) {
            reviewPermanentlyEnabled = true;
            enableReview();
          }
        }
      });
    });
  }

  // attach sidebar link handlers
  function attachSidebarLinks() {
    // exam1/exam2 -> go to first page
    var examEls = document.querySelectorAll('.exam1, .exam2');
    examEls.forEach(function (el) {
      el.addEventListener('click', function () { showPage(1); });
    });

    // review click: if disabled do nothing; if enabled, go to page 1 and keep enabled permanently
    var reviewEls = [];
    var r1 = document.querySelectorAll('.review1, .review2');
    r1.forEach(function (e) { reviewEls.push(e); });
    if (reviewBtn) reviewEls.push(reviewBtn);

    reviewEls.forEach(function (el) {
      el.addEventListener('click', function (ev) {
        // ignore if disabled
        if (el.classList && el.classList.contains('disabled-link')) {
          ev.preventDefault();
          return;
        }
        ev.preventDefault();
        // enable permanently and go to first page
        reviewPermanentlyEnabled = true;
        enableReview();
        showPage(1);
      });
    });
  }

  // Attach zoom overlay handlers for images
  function attachImageFullscreen() {
    var overlay = document.getElementById('fullscreenOverlay');
    var overlayImg = document.getElementById('fullscreenImg');
    var closeBtn = document.getElementById('closeFullscreen');

    function openFull(src) {
      if (!overlay || !overlayImg) return;
      overlayImg.src = src;
      overlay.style.display = 'flex';
      overlay.classList.add('show');
      overlay.setAttribute('aria-hidden', 'false');
      try { document.body.style.overflow = 'hidden'; } catch (e) {}
    }
    function closeFull() {
      if (!overlay || !overlayImg) return;
      overlay.classList.remove('show');
      overlay.style.display = 'none';
      overlay.setAttribute('aria-hidden', 'true');
      overlayImg.src = '';
      try { document.body.style.overflow = ''; } catch (e) {}
    }

    // click thumbnails
    var qimages = document.querySelectorAll('.q-image');
    qimages.forEach(function (img) {
      img.addEventListener('click', function () {
        var src = img.getAttribute('data-full') || img.src;
        openFull(src);
      });
    });

    // close handlers
    if (closeBtn) closeBtn.addEventListener('click', closeFull);
    if (overlay) {
      overlay.addEventListener('click', function (e) {
        // close when clicking on overlay background (not the image)
        if (e.target === overlay) closeFull();
      });
    }
    // Esc key
    document.addEventListener('keydown', function (ev) {
      if (ev.key === 'Escape') {
        if (overlay && overlay.style.display === 'flex') closeFull();
      }
    });
  }

  // Initialize everything
  showPage(1);
  attachAnswerNavClicks();
  attachAnswerRadios();
  attachSidebarLinks();
  attachImageFullscreen();

  // robustness: re-attach after a short delay in case content loads slightly later
  setTimeout(function () {
    attachAnswerNavClicks();
    attachAnswerRadios();
    attachImageFullscreen();
  }, 300);
});
