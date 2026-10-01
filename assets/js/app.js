$(function () {
  $('a[href="#how"]').on('click', function (e) {
    e.preventDefault();
    $('html, body').animate({ scrollTop: $('#how-it-works').offset().top - 80 }, 400);
  });

  $('.navbar-nav .nav-link').filter(function () {
    return $(this).text().trim() === 'About us';
  }).on('click', function (e) {
    e.preventDefault();
    $('html, body').animate({ scrollTop: $('#about-us').offset().top - 80 }, 400);
  });

  $('.navbar-nav .nav-link').filter(function () {
    return $(this).text().trim() === 'How it works';
  }).on('click', function (e) {
    e.preventDefault();
    $('html, body').animate({ scrollTop: $('#how-it-works').offset().top - 80 }, 400);
  });

  $(window).on('scroll', function () {
    if ($(this).scrollTop() > 10) {
      $('#main-nav').css('box-shadow', '0 2px 12px rgba(0,0,0,0.07)');
    } else {
      $('#main-nav').css('box-shadow', 'none');
    }
  });

  $('#btn-upload').on('click', function () { window.location.href = 'jobs.php'; });
  $('#btn-login').on('click', function () { window.location.href = 'login.php'; });
  $('#btn-signup').on('click', function () { window.location.href = 'register.php'; });

  $('.step-card').on('mouseenter', function () {
    $(this).find('.step-number').animate({ opacity: 0.4 }, 150, function () {
      $(this).css('color', '#534AB7').animate({ opacity: 1 }, 150);
    });
  }).on('mouseleave', function () {
    $(this).find('.step-number').animate({ opacity: 0.4 }, 150, function () {
      $(this).css('color', '#AFA9EC').animate({ opacity: 1 }, 150);
    });
  });
});
