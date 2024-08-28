<?php
$fiats_array = [
    [
        "imgPath" => "static/img/Euro.png",
        "currencySymbol" => "EUR",
        "currencyName" => "Euro",
        "currencyAmount" => "301849.74"
    ],
    [
        "imgPath" => "static/img/USD.png",
        "currencySymbol" => "USD",
        "currencyName" => "American Dollar",
        "currencyAmount" => "450000.00"
    ],
    [
        "imgPath" => "static/img/BGN.png",
        "currencySymbol" => "BGN",
        "currencyName" => "Bulgarian Lev",
        "currencyAmount" => "120000.00"
    ]
];

$crypto_array = [
    [
        "imgPath" => "static/img/Cardano.png",
        "currencySymbol" => "ADA",
        "currencyName" => "Cardano",
        "currencyAmount" => "1712.00"
    ],
    [
        "imgPath" => "static/img/Bitcoin.png",
        "currencySymbol" => "BTC",
        "currencyName" => "Bitcoin",
        "currencyAmount" => "993.313456"
    ],
    [
        "imgPath" => "static/img/Ethereum.png",
        "currencySymbol" => "ETH",
        "currencyName" => "Ethereum",
        "currencyAmount" => "82.02"
    ],
    [
        "imgPath" => "static/img/Tether.png",
        "currencySymbol" => "USDT",
        "currencyName" => "Tether",
        "currencyAmount" => "208849.74"
    ]
];
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Crypto Wallet</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
          integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="static/styles/main.css">
</head>
<body>
<nav class="navbar navbar-expand-lg">
    <div class="container-fluid">
        <a class="navbar-brand" href="#"><img src="static/img/image%208.png"></a>
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <li class="nav-item">
                <a class="nav-link" aria-current="page" href="#">By Crypto</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" aria-current="page" href="#">Markets</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" aria-current="page" href="#">Trade</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" aria-current="page" href="#">Leverage</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" aria-current="page" href="#">Earn</a>
            </li>
            <li class="nav-item active">
                <a class="nav-link active" aria-current="page" href="#">Wallet</a>
            </li>
        </ul>
    </div>
</nav>
<div class="container">
    <nav>
        <div class="sidebar">
            <ul class="nav flex-column">
                <li class="nav-item active">
                    <a class="nav-link" aria-current="page" href="#"><img src="static/img/image%201.png"> My Wallet</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#"><img src="static/img/image%202.png"> Internal Transfer</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#"><img src="static/img/image%206.png"> Deposit</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#"><img src="static/img/image%204.png"> Exchange</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#"><img src="static/img/image%207.png"> Withdraw</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#"><img src="static/img/Frame.png"> Get Staking</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#"><img src="static/img/image%205.png"> Get Loan</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#"><img src="static/img/image%203.png"> Transaction History</a>
                </li>
            </ul>
        </div>
    </nav>
</div>
<div class="page-title">
    <div class="page-title-section-left">
        <h1>Wallet Overview</h1>
    </div>
    <div class="page-title-section-right-position">
        <div class="page-title-section-right">

            <button class="btn-main">Deposit</button>
            <button class="btn-secondary">Withdraw</button>
            <button class="btn-secondary">Transfer</button>
        </div>
    </div>
</div>

<div class="balance-container">
    <div class="balance">
        <div class="estimated-balance">Estimated Balance</div>
        <div class="balance-value">993,313456 BTC <img src="static/img/Vector%202.png"></div>
        <ul>
            <li><img src="static/img/Rectangle%2064.png"> Euro <span> 38%</span></li>
            <li><img src="static/img/Rectangle%2065.png"> USD <span> 42%</span></li>
            <li><img src="static/img/Rectangle%2066.png"> USDT <span> 12%</span></li>
            <li><img src="static/img/Rectangle%2067.png"> BGN <span> 21%</span></li>
        </ul>
    </div>
    <div class="balance-diagram">
        <img src="static/img/Frame.jpg">
    </div>
</div>
<div class="fiat-balance">
    <div>Fiat Balance</div>
</div>
<div class="fiat-cards-container">
    <div class="row">
        <?php foreach ($fiats_array as $fiat) { ?>
            <div class="col-md-4">
                <div class="card bg-light mb-3" style="max-width: 25rem;">
                    <div class="card-header">
                        <div class="section-left">
                            <img src=<?php echo $fiat["imgPath"] ?>>
                            <div><?php echo $fiat["currencySymbol"] ?></div>
                            <span class="currency-full-name"><?php echo $fiat["currencyName"] ?></span>
                        </div>
                        <div class="section-right">
                            <div class="card-balance"><?php echo $fiat["currencyAmount"] ?><?php echo $fiat["currencySymbol"] ?></div>
                        </div>
                    </div>
                    <div class="card-body">
                        <button class="card-btn-main">Deposit</button>
                        <button class="card-btn-secondary">Exchange</button>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
</div>
<div class="fiat-balance">
    <div>Crypto Balance</div>
</div>
<div class="fiat-cards-container">
    <div class="row">
        <?php foreach ($crypto_array as $crypto) { ?>
            <div class="col-md-4">
                <div class="card bg-light mb-3" style="max-width: 25rem;">
                    <div class="card-header">
                        <div class="section-left">
                            <img src=<?php echo $crypto["imgPath"] ?>>
                            <div><?php echo $crypto["currencySymbol"] ?></div>
                            <span class="currency-full-name"><?php echo $crypto["currencyName"] ?></span>
                        </div>
                        <div class="section-right">
                            <div class="card-balance"><?php echo $crypto["currencyAmount"] ?><?php echo $crypto["currencySymbol"] ?></div>
                        </div>
                    </div>
                    <div class="card-body">
                        <button class="card-btn-main">Deposit</button>
                        <button class="card-btn-secondary">Exchange</button>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
</div>
<footer>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3">
                <div class="footer-heading">Company</div>
                <ul>
                    <li>About Us</li>
                    <li>Careers</li>
                    <li>Bug Bounty</li>
                    <li>Blog</li>
                    <li>Refer a Friend</li>
                </ul>
            </div>
            <div class="col-md-3">
                <div class="footer-heading">Legal</div>
                <ul>
                    <li>Privacy Policy</li>
                    <li>Terms & Conditions</li>
                    <li>GDPR</li>
                    <li>AML Policy</li>
                    <li>Licenses</li>
                </ul>
            </div>
            <div class="col-md-3">
                <div class="footer-heading">Help</div>
                <ul>
                    <li>Fees</li>
                    <li>Help Center</li>
                    <li>Security</li>
                    <li>Bitcoin Loans</li>
                    <li>Ethereum Loans</li>
                </ul>
            </div>
            <div class="col-md-3">
                <div class="footer-heading">Follow Us</div>
                <div class="footer-icons">
                    <img src="static/img/XMLID_16_.png">
                    <img src="static/img/XMLID_17_%20.png">
                    <img src="static/img/XMLID_18_.png">
                </div>
            </div>
        </div>
        <div class="copyright">
            <span class="copyright-text">Copyright 2024 Test</span>
        </div>
    </div>
</footer>


</body>
</html>