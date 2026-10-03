<?php
// Fix home.blade.php
$homePath = 'c:\\xampp\\htdocs\\tourism\\resources\\views\\home.blade.php';
$content = file_get_contents($homePath);
if (strpos($content, '@media (max-width: 991px)') === false) {
    $css = <<<'EOD'

    /* Responsive Media Queries */
    @media (max-width: 991px) {
        .hero-title { font-size: 2.8rem; }
        .search-box { grid-template-columns: 1fr 1fr; gap: 0.8rem; }
        .stats-grid { grid-template-columns: repeat(2, 1fr); }
        .cat-grid { grid-template-columns: repeat(2, 1fr); }
        .dest-grid { grid-template-columns: repeat(2, 1fr); }
    }
    
    @media (max-width: 768px) {
        .hero-title { font-size: 2.2rem; }
        .search-box { grid-template-columns: 1fr; }
        .search-input { margin-bottom: 0.5rem; }
        .btn-primary { width: 100%; justify-content: center; margin-top: 0.5rem; }
        .stats-grid { grid-template-columns: 1fr 1fr; gap: 1rem; }
        .cat-grid { grid-template-columns: 1fr; }
        .dest-grid { grid-template-columns: 1fr; }
        .section-title { font-size: 1.8rem; }
    }
</style>
EOD;
    $content = str_replace('</style>', $css, $content);
    file_put_contents($homePath, $content);
}

// Fix app.blade.php
$appPath = 'c:\\xampp\\htdocs\\tourism\\resources\\views\\layouts\\app.blade.php';
$appContent = file_get_contents($appPath);
if (strpos($appContent, '@media (max-width: 768px)') === false) {
    $appCss = <<<'EOD'

    /* App Layout Responsive */
    @media (max-width: 768px) {
        .navbar .container { flex-direction: column; gap: 1rem; }
        .nav-links { flex-wrap: wrap; justify-content: center; gap: 10px; }
        .footer-grid { grid-template-columns: 1fr !important; gap: 2rem !important; text-align: center; }
        .footer-logo { margin: 0 auto 1rem auto !important; justify-content: center; }
        .social-links { justify-content: center; }
    }
</style>
EOD;
    $appContent = str_replace('</style>', $appCss, $appContent);
    file_put_contents($appPath, $appContent);
}

echo "Responsive CSS added successfully!";
