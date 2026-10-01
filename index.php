<?php
session_start();

$isLoggedIn = !empty($_SESSION['user_id']);
$userName   = $isLoggedIn ? ($_SESSION['user_name'] ?? 'there') : '';

function e(string $s): string {
    return htmlspecialchars($s, ENT_QUOTES, 'UTF-8');
}

function lamp_svg(int $size = 280, bool $sparkles = true): string {
    $extra = $sparkles ? '
      <path d="M122 88 Q112 78 118 70" stroke="#FAC775" stroke-width="1.5" stroke-linecap="round" fill="none" opacity="0.7"/>
      <path d="M122 86 Q108 84 110 75" stroke="#FAC775" stroke-width="1.5" stroke-linecap="round" fill="none" opacity="0.5"/>
      <circle cx="168" cy="78" r="3" fill="#FAC775" opacity="0.7"/>
      <circle cx="104" cy="63" r="2" fill="#FAC775" opacity="0.5"/>
      <circle cx="183" cy="99" r="2.5" fill="#AFA9EC" opacity="0.6"/>
      <circle cx="97" cy="103" r="2" fill="#AFA9EC" opacity="0.5"/>' : '';
    return '<svg width="' . $size . '" height="' . $size . '" viewBox="0 0 280 280" fill="none" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Genie lamp illustration">
      <ellipse cx="140" cy="220" rx="88" ry="13" fill="#EEEDFE"/>
      <path d="M88 183 Q69 162 71 143 Q73 124 93 119 Q113 114 123 124 L157 124 Q167 114 187 119 Q207 124 209 143 Q211 162 192 183 Z" fill="#7F77DD"/>
      <path d="M123 124 Q140 109 157 124 L162 178 Q152 188 140 188 Q128 188 118 178 Z" fill="#534AB7"/>
      <ellipse cx="140" cy="122" rx="18" ry="7" fill="#AFA9EC"/>
      <path d="M140 115 Q148 96 152 81 Q156 66 148 56 Q142 47 135 52 Q129 57 134 65 Q138 73 136 80 Q134 87 128 90" stroke="#EF9F27" stroke-width="2.5" stroke-linecap="round" fill="none"/>
      <circle cx="127" cy="91" r="6" fill="#FAC775"/>
      <circle cx="127" cy="91" r="3" fill="#BA7517"/>
      <path d="M192 183 Q211 178 220 172 Q234 165 229 156 Q224 148 215 153 Q206 158 201 153" stroke="#7F77DD" stroke-width="3" stroke-linecap="round" fill="none"/>
      <circle cx="201" cy="151" r="5" fill="#534AB7"/>
      <path d="M68 183 Q51 180 46 174 Q41 167 49 161 Q57 155 65 161" stroke="#7F77DD" stroke-width="3" stroke-linecap="round" fill="none"/>
      <circle cx="65" cy="181" r="4" fill="#534AB7"/>' . $extra . '
    </svg>';
}

/* Icon helper (Feather-style, purple stroke) */
function icon(string $paths): string {
    return '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#534AB7" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">' . $paths . '</svg>';
}

$steps = [
    ['title' => 'Upload your resume',
     'desc'  => 'Drop in a PDF. It takes under a minute.',
     'icon'  => '<path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/>'],
    ['title' => 'AI reads your background',
     'desc'  => 'Skills, experience and preferences are pulled out automatically.',
     'icon'  => '<path d="M9.5 2A2.5 2.5 0 0 1 12 4.5v15a2.5 2.5 0 0 1-4.96-.46 2.5 2.5 0 0 1-2.96-3.08 3 3 0 0 1-.34-5.58 2.5 2.5 0 0 1 1.32-4.88A2.5 2.5 0 0 1 9.5 2"/><path d="M14.5 2A2.5 2.5 0 0 0 12 4.5v15a2.5 2.5 0 0 0 4.96-.46 2.5 2.5 0 0 0 2.96-3.08 3 3 0 0 0 .34-5.58 2.5 2.5 0 0 0-1.32-4.88A2.5 2.5 0 0 0 14.5 2"/>'],
    ['title' => 'Search real job listings',
     'desc'  => 'Major job boards are scanned for openings that match you.',
     'icon'  => '<circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>'],
    ['title' => 'Review your matches',
     'desc'  => 'Compare the options and pick the ones that truly fit.',
     'icon'  => '<circle cx="12" cy="8" r="6"/><path d="M15.477 12.89 17 22l-5-3-5 3 1.523-9.11"/>'],
];

$features = [
    ['title' => 'Match scores',
     'desc'  => 'Every job gets a score that shows how closely it lines up with your skills.',
     'icon'  => '<polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/>'],
    ['title' => 'Tailored resume',
     'desc'  => 'Get a version of your resume rewritten around the job you are applying to.',
     'icon'  => '<path d="M12 20h9"/><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4z"/>'],
    ['title' => 'Cover letter draft',
     'desc'  => 'A first draft that uses details from your resume and the job post.',
     'icon'  => '<path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/>'],
    ['title' => 'Skill gap hints',
     'desc'  => 'See which skills a role asks for that your resume does not show yet.',
     'icon'  => '<circle cx="12" cy="12" r="10"/><circle cx="12" cy="12" r="6"/><circle cx="12" cy="12" r="2"/>'],
    ['title' => 'Saved jobs',
     'desc'  => 'Keep the roles you like in one place and come back to them later.',
     'icon'  => '<path d="M19 21l-7-5-7 5V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2z"/>'],
    ['title' => 'Private by default',
     'desc'  => 'Your resume stays tied to your account and is not shown to other users.',
     'icon'  => '<rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/>'],
];

$faqs = [
    ['q' => 'What file types can I upload?',
     'a' => 'Right now RoleGenie accepts PDF resumes. Make sure the text is selectable and not a scanned image so the AI can read it.'],
    ['q' => 'Where do the job listings come from?',
     'a' => 'Listings are pulled from job search APIs and shown with a link back to the original posting, so you apply on the employer or job board site.'],
    ['q' => 'Does the AI change my resume without asking?',
     'a' => 'No. Tailored resumes and cover letters are generated as drafts. You review and edit them before using anything.'],
    ['q' => 'Is RoleGenie free?',
     'a' => 'It is a student capstone project, so there is no charge to try it.'],
    ['q' => 'Who can see my resume?',
     'a' => 'Only you, through your logged-in account. It is not shared with other users.'],
];

$year = date('Y');
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="description" content="RoleGenie uses AI agents to read your resume, search real job listings and tailor your application." />
  <title>RoleGenie — AI agents that find your perfect role</title>

  <!-- Bootstrap 5 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500&family=Inter:wght@400;500&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="assets/css/style.css" />

  <!-- Styles for the new sections (kept here so style.css stays untouched) -->
  <style>
    html { scroll-behavior: smooth; }
    section[id] { scroll-margin-top: 80px; }

    .rg-section { padding: 80px 0; }
    .rg-section.alt { background: #F7F6FE; }

    .rg-mini-title { font-family: 'Playfair Display', serif; font-weight: 500; color: #26215C; }
    .rg-muted { color: #6B6985; }

    /* hero extras */
    .hero-greeting {
      display: inline-block; margin-bottom: 14px; padding: 6px 14px;
      background: #EEEDFE; color: #3C3489; border-radius: 999px; font-size: 14px;
    }
    .hero-note { margin-top: 14px; font-size: 13px; color: #6B6985; }
    .btn-cta-secondary {
      display: inline-flex; align-items: center; gap: 8px;
      padding: 12px 22px; border-radius: 10px; background: transparent;
      color: #534AB7; border: 1.5px solid #AFA9EC; font-weight: 500; text-decoration: none;
      transition: background .15s ease;
    }
    .btn-cta-secondary:hover { background: #EEEDFE; color: #3C3489; }

    /* upload drop zone */
    .drop-zone {
      margin-top: 22px; padding: 18px; max-width: 440px;
      border: 1.5px dashed #AFA9EC; border-radius: 14px; background: #FBFAFF;
      text-align: center; font-size: 14px; color: #6B6985; cursor: pointer;
      transition: background .15s ease, border-color .15s ease;
    }
    .drop-zone.is-over { background: #EEEDFE; border-color: #534AB7; }
    .drop-zone strong { color: #534AB7; }

    /* job match preview (mock data, just for the landing page) */
    .match-preview {
      background: #fff; border: 1px solid #E3E1F6; border-radius: 16px;
      padding: 20px; max-width: 420px; margin: 0 auto;
      box-shadow: 0 10px 30px rgba(83, 74, 183, .08);
    }
    .match-row { display: flex; align-items: center; justify-content: space-between; gap: 12px; padding: 12px 0; }
    .match-row + .match-row { border-top: 1px solid #EEEDFE; }
    .match-role { font-weight: 500; margin: 0; color: #26215C; }
    .match-co { margin: 0; font-size: 13px; color: #6B6985; }
    .match-score {
      min-width: 56px; text-align: center; padding: 4px 10px; border-radius: 999px;
      font-size: 13px; font-weight: 500; background: #EEEDFE; color: #3C3489;
    }
    .match-score.high { background: #E1F5EE; color: #0F6E56; }

    /* feature cards */
    .feature-card {
      height: 100%; padding: 24px; background: #fff;
      border: 1px solid #E3E1F6; border-radius: 14px;
    }
    .feature-icon {
      width: 38px; height: 38px; border-radius: 10px; background: #EEEDFE;
      display: flex; align-items: center; justify-content: center; margin-bottom: 14px;
    }
    .feature-card h3 { font-size: 17px; font-weight: 500; margin-bottom: 6px; color: #26215C; }
    .feature-card p { font-size: 14px; margin: 0; color: #6B6985; }

    /* FAQ */
    .rg-faq .accordion-item { border: 1px solid #E3E1F6; border-radius: 12px !important; overflow: hidden; margin-bottom: 10px; }
    .rg-faq .accordion-button { font-weight: 500; color: #26215C; background: #fff; box-shadow: none; }
    .rg-faq .accordion-button:not(.collapsed) { background: #F7F6FE; color: #3C3489; }
    .rg-faq .accordion-button:focus { box-shadow: 0 0 0 3px rgba(127, 119, 221, .3); }
    .rg-faq .accordion-body { color: #6B6985; font-size: 15px; }

    /* bottom CTA */
    .cta-band {
      background: #3C3489; color: #fff; border-radius: 20px;
      padding: 48px 28px; text-align: center;
    }
    .cta-band h2 { font-family: 'Playfair Display', serif; font-weight: 500; margin-bottom: 10px; }
    .cta-band p { color: #CECBF6; margin-bottom: 22px; }
    .cta-band .btn-light { color: #3C3489; font-weight: 500; padding: 12px 26px; border-radius: 10px; }

    /* footer extras */
    .footer-links { display: flex; gap: 20px; flex-wrap: wrap; }
    .footer-links a { color: inherit; opacity: .75; text-decoration: none; font-size: 14px; }
    .footer-links a:hover { opacity: 1; text-decoration: underline; }
    .footer-copy { font-size: 13px; opacity: .7; }

    /* nav user chip */
    .nav-user { font-size: 14px; color: #3C3489; }

    a:focus-visible, button:focus-visible { outline: 3px solid #AFA9EC; outline-offset: 2px; }
    @media (prefers-reduced-motion: reduce) { html { scroll-behavior: auto; } * { transition: none !important; } }
  </style>
</head>
<body>

  <!-- ===== Navbar ===== -->
  <nav id="main-nav" class="navbar navbar-expand-lg">
    <div class="container">

      <a class="nav-logo" href="index.php">
        <div class="logo-mark">
          <svg width="22" height="22" viewBox="40 40 200 190" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
            <ellipse cx="140" cy="220" rx="88" ry="13" fill="#EEEDFE"/>
            <path d="M88 183 Q69 162 71 143 Q73 124 93 119 Q113 114 123 124 L157 124 Q167 114 187 119 Q207 124 209 143 Q211 162 192 183 Z" fill="#7F77DD"/>
            <path d="M123 124 Q140 109 157 124 L162 178 Q152 188 140 188 Q128 188 118 178 Z" fill="#534AB7"/>
            <ellipse cx="140" cy="122" rx="18" ry="7" fill="#AFA9EC"/>
            <path d="M140 115 Q148 96 152 81 Q156 66 148 56 Q142 47 135 52 Q129 57 134 65 Q138 73 136 80 Q134 87 128 90" stroke="#EF9F27" stroke-width="2.5" stroke-linecap="round" fill="none"/>
            <circle cx="127" cy="91" r="6" fill="#FAC775"/>
            <circle cx="127" cy="91" r="3" fill="#BA7517"/>
          </svg>
        </div>
        RoleGenie
      </a>

      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu" aria-controls="navMenu" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navMenu">
        <ul class="navbar-nav mx-auto">
          <li class="nav-item"><a class="nav-link" href="#how-it-works">How it works</a></li>
          <li class="nav-item"><a class="nav-link" href="#features">Features</a></li>
          <li class="nav-item"><a class="nav-link" href="#faq">FAQ</a></li>
          <li class="nav-item"><a class="nav-link" href="#about-us">About us</a></li>
        </ul>

        <div class="d-flex gap-2 align-items-center">
          <?php if ($isLoggedIn): ?>
            <span class="nav-user">Hi, <?= e($userName) ?></span>
            <a class="btn-nav-login text-decoration-none" href="dashboard.php">Dashboard</a>
            <a class="btn-nav-signup text-decoration-none" href="logout.php">Log out</a>
          <?php else: ?>
            <button class="btn-nav-login" id="btn-login">Log in</button>
            <button class="btn-nav-signup" id="btn-signup">Sign up</button>
          <?php endif; ?>
        </div>
      </div>

    </div>
  </nav>

  <main>

    <!-- ===== Hero ===== -->
    <section id="hero">
      <div class="container">
        <div class="row align-items-center g-0">

          <div class="col-lg-6 pe-lg-5 mb-5 mb-lg-0">
            <?php if ($isLoggedIn): ?>
              <span class="hero-greeting">Welcome back, <?= e($userName) ?></span>
            <?php else: ?>
              <p class="hero-eyebrow">AI-powered job search</p>
            <?php endif; ?>

            <h1 class="hero-headline">
              Your wish for the<br>
              <em>perfect role</em><br>
              — granted.
            </h1>
            <p class="hero-subtext">
              Upload your resume and our AI agents will scan thousands of jobs, write a tailored resume and cover letter for each one, and help you apply with confidence.
            </p>

            <div class="d-flex flex-wrap gap-3">
              <button class="btn-cta-primary" id="btn-upload">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M4 17v2a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-2"/><polyline points="7 9 12 4 17 9"/><line x1="12" y1="4" x2="12" y2="16"/></svg>
                Upload resume
              </button>
              <a class="btn-cta-secondary" href="#how-it-works">See how it works</a>
            </div>

            <p class="hero-note">PDF only. Your resume stays private to your account.</p>
          </div>

          <div class="col-lg-6">
            <div class="hero-illustration">
              <?= lamp_svg(280, true) ?>
            </div>
          </div>

        </div>
      </div>
    </section>

    <!-- ===== How it works ===== -->
    <section id="how-it-works" class="rg-section">
      <div class="container text-center">

        <p class="section-eyebrow">How it works</p>
        <h2 class="section-title">Your AI role-searching partner</h2>
        <p class="section-sub">Four steps from resume to matches.</p>

        <div class="row g-3">
          <?php foreach ($steps as $i => $step): ?>
            <div class="col-sm-6 col-lg-3">
              <div class="step-card text-start">
                <div class="step-number"><?= str_pad((string)($i + 1), 2, '0', STR_PAD_LEFT) ?></div>
                <div class="step-icon-wrap"><?= icon($step['icon']) ?></div>
                <p class="step-title"><?= e($step['title']) ?></p>
                <p class="step-desc"><?= e($step['desc']) ?></p>
              </div>
            </div>
          <?php endforeach; ?>
        </div>

      </div>
    </section>

    <!-- ===== Match preview ===== -->
    <section id="preview" class="rg-section alt">
      <div class="container">
        <div class="row align-items-center g-5">

          <div class="col-lg-6">
            <h2 class="section-title text-start">See how your matches look</h2>
            <p class="rg-muted">
              Each result shows the role, the company and a match score based on your resume. Open any job to get a tailored resume and cover letter draft.
            </p>
            <a class="btn-cta-primary text-decoration-none d-inline-flex" href="#hero" id="btn-preview-cta">Try it with your resume</a>
          </div>

          <div class="col-lg-6">
            <div class="match-preview" aria-label="Example job matches">
              <p class="rg-muted mb-1" style="font-size:13px;">Example results</p>
              <div class="match-row">
                <div>
                  <p class="match-role">Junior Web Developer</p>
                  <p class="match-co">Sample Company A</p>
                </div>
                <span class="match-score high">92%</span>
              </div>
              <div class="match-row">
                <div>
                  <p class="match-role">Software Engineer I</p>
                  <p class="match-co">Sample Company B</p>
                </div>
                <span class="match-score high">86%</span>
              </div>
              <div class="match-row">
                <div>
                  <p class="match-role">QA Analyst</p>
                  <p class="match-co">Sample Company C</p>
                </div>
                <span class="match-score">71%</span>
              </div>
            </div>
          </div>

        </div>
      </div>
    </section>

    <!-- ===== Features ===== -->
    <section id="features" class="rg-section">
      <div class="container text-center">

        <p class="section-eyebrow">Features</p>
        <h2 class="section-title">Everything you need to apply faster</h2>
        <p class="section-sub">From the first search to the final draft.</p>

        <div class="row g-3 text-start">
          <?php foreach ($features as $f): ?>
            <div class="col-md-6 col-lg-4">
              <div class="feature-card">
                <div class="feature-icon"><?= icon($f['icon']) ?></div>
                <h3><?= e($f['title']) ?></h3>
                <p><?= e($f['desc']) ?></p>
              </div>
            </div>
          <?php endforeach; ?>
        </div>

      </div>
    </section>

    <!-- ===== FAQ ===== -->
    <section id="faq" class="rg-section alt">
      <div class="container" style="max-width: 760px;">

        <div class="text-center mb-4">
          <p class="section-eyebrow">FAQ</p>
          <h2 class="section-title">Questions people ask</h2>
        </div>

        <div class="accordion rg-faq" id="faqAccordion">
          <?php foreach ($faqs as $i => $faq): ?>
            <div class="accordion-item">
              <h3 class="accordion-header">
                <button class="accordion-button <?= $i === 0 ? '' : 'collapsed' ?>" type="button"
                        data-bs-toggle="collapse" data-bs-target="#faq<?= $i ?>"
                        aria-expanded="<?= $i === 0 ? 'true' : 'false' ?>" aria-controls="faq<?= $i ?>">
                  <?= e($faq['q']) ?>
                </button>
              </h3>
              <div id="faq<?= $i ?>" class="accordion-collapse collapse <?= $i === 0 ? 'show' : '' ?>" data-bs-parent="#faqAccordion">
                <div class="accordion-body"><?= e($faq['a']) ?></div>
              </div>
            </div>
          <?php endforeach; ?>
        </div>

      </div>
    </section>

    <!-- ===== About project ===== -->
    <section id="about-us" class="rg-section">
      <div class="container text-center">
        <p class="section-eyebrow">About the project</p>
        <h2 class="section-title">Job Finder — Personal Extension</h2>
        <p class="section-sub" style="max-width:680px; margin-left:auto; margin-right:auto;">
          A PHP/MySQL job-search application extended from an existing codebase. This personal edition focuses on adding and refining use cases and features, improving the user experience, troubleshooting application behavior, and completing final functional and end-to-end testing.
        </p>
        <div class="about-badge">
          PHP &bull; MySQL &bull; HTML &bull; CSS &bull; JavaScript &bull; Bootstrap &bull; REST APIs
        </div>
      </div>
    </section>

    <!-- ===== Bottom CTA ===== -->
    <section class="rg-section pt-0">
      <div class="container">
        <div class="cta-band">
          <h2>Ready to find your next role?</h2>
          <p>Upload your resume and see your first matches in minutes.</p>
          <a class="btn btn-light" href="#hero" id="btn-bottom-cta">Upload resume</a>
        </div>
      </div>
    </section>

  </main>

  <!-- ===== Footer ===== -->
  <footer id="footer">
    <div class="container d-flex justify-content-between align-items-center flex-wrap gap-3">
      <span class="footer-logo">RoleGenie</span>
      <nav class="footer-links" aria-label="Footer">
        <a href="#how-it-works">How it works</a>
        <a href="#features">Features</a>
        <a href="#faq">FAQ</a>
        <a href="#about-us">About us</a>
      </nav>
      <span class="footer-copy">&copy; <?= $year ?> RoleGenie. ICS499 capstone project.</span>
    </div>
  </footer>

  <!-- Bootstrap 5 JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <!-- jQuery -->
  <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script>
  <script src="assets/js/app.js"></script>

  <!-- Small extras: the bottom CTA buttons reuse the main upload button's behavior -->
  <script>
    (function () {
      var upload = document.getElementById('btn-upload');
      ['btn-preview-cta', 'btn-bottom-cta'].forEach(function (id) {
        var el = document.getElementById(id);
        if (el && upload) {
          el.addEventListener('click', function (ev) {
            ev.preventDefault();
            upload.click();
          });
        }
      });
    })();
  </script>

</body>
</html>