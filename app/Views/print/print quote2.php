<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quotation - <?= esc($invDetails[0]['invid']); ?></title>

    <?= $this->include('include/links.php'); ?>

    <style>
        /* ==========================================================
           GLOBAL
        ========================================================== */

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        html,
        body {
            margin: 0;
            padding: 0;
        }

        body {
            background: #e5e7eb;
            font-family: Arial, Helvetica, sans-serif;
            color: #1f2937;
            font-size: 14px;
            line-height: 1.5;
            display: flex;
            flex-direction: column;
            align-items: center;
            min-height: 100vh;
            padding: 20px 0;
        }

        /* ==========================================================
           PDF CONTENT WRAPPER - CENTERED
        ========================================================== */

        #pdf-content {
            display: flex;
            flex-direction: column;
            align-items: center;
            width: 100%;
            max-width: 210mm;
        }

        /* ==========================================================
           A4 PAGE - ORIGINAL GRADIENTS RESTORED
        ========================================================== */

        .quotation-page {
            width: 210mm;
            min-height: 297mm;
            padding: 13mm 15mm 15mm 15mm;
            position: relative;
            overflow: hidden;
            background: linear-gradient(135deg, #ffffff 0%, #f8fbff 48%, #eef5ff 100%);
            border-top: 6px solid #172554;
            box-shadow: 0 4px 25px rgba(0, 0, 0, 0.12);
            margin-bottom: 30px;
        }

        .quotation-page:last-child {
            margin-bottom: 0;
        }

        /* ==========================================================
           PREMIUM ABSTRACT BACKGROUND - ORIGINAL GRADIENTS RESTORED
        ========================================================== */

        .quotation-page::before {
            content: "";
            position: absolute;
            top: -180px;
            right: -150px;
            width: 430px;
            height: 430px;
            border-radius: 50%;
            background: linear-gradient(135deg, #172554, #2563eb, #06b6d4);
            opacity: 0.10;
            pointer-events: none;
        }

        .quotation-page::after {
            content: "";
            position: absolute;
            bottom: -180px;
            left: -170px;
            width: 420px;
            height: 420px;
            border-radius: 50%;
            background: linear-gradient(135deg, #06b6d4, #2563eb, #172554);
            opacity: 0.08;
            pointer-events: none;
        }

        .quotation-page>* {
            position: relative;
            z-index: 2;
        }

        /* ==========================================================
           PAGE 1 - ORIGINAL PADDING
        ========================================================== */

        #page1 {
            padding: 13mm 15mm 15mm 15mm;
        }

        /* ==========================================================
           PAGE 2 - EXTRA TIGHT PADDING TO FIT CONTENT
        ========================================================== */

        #page2 {
            padding: 8mm 13mm 6mm 13mm;
        }

        /* ==========================================================
           HEADER LINE - ORIGINAL GRADIENT RESTORED
        ========================================================== */

        .header-line {
            width: 100%;
            height: 4px;
            margin-top: 10px;
            background: linear-gradient(90deg, #172554 0%, #2563eb 45%, #06b6d4 75%, #94a3b8 100%);
            border-radius: 4px;
            display: block;
            position: relative;
            z-index: 10;
        }

        /* ==========================================================
           COMPANY HEADER
        ========================================================== */

        .company-header {
            width: 100%;
            padding-bottom: 10px;
            position: relative;
        }

        .company-logo {
            width: 100%;
        }

        .company-logo img {
            display: block;
            width: 100%;
            max-width: 100%;
            height: auto;
        }

        /* ==========================================================
           SUBJECT LINE - ORIGINAL GRADIENT RESTORED
        ========================================================== */

        .subject-line {
            width: 80px;
            height: 4px;
            margin-top: 8px;
            background: linear-gradient(90deg, #172554, #2563eb, #06b6d4);
            border-radius: 5px;
        }

        /* ==========================================================
           REFERENCE / DATE
        ========================================================== */

        .quote-meta {
            width: 100%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 0px;
            margin-bottom: 22px;
            font-size: 15px;
            line-height: 1.5;
            color: #111827;
        }

        .quote-reference {
            text-align: left;
        }

        .quote-date {
            text-align: right;
            margin-right: 20px;
        }

        /* ==========================================================
           CUSTOMER DETAILS
        ========================================================== */

        .customer-details {
            width: 100%;
            margin-bottom: 25px;
            font-size: 15px;
            line-height: 1.55;
            color: #111827;
        }

        .to-label {
            margin-bottom: 3px;
        }

        .customer-name-old {
            font-size: 15px;
            font-weight: bold;
            margin-bottom: 2px;
        }

        .customer-address-old {
            font-size: 14px;
            line-height: 1.55;
            color: #374151;
        }

        /* ==========================================================
           KIND ATTENTION
        ========================================================== */

        .attention {
            width: 100%;
            text-align: center;
            font-size: 15px;
            line-height: 1.5;
            margin-top: 8px;
            margin-bottom: 20px;
        }

        /* ==========================================================
           SUBJECT
        ========================================================== */

        .subject-section {
            width: 100%;
            margin-top: 10px;
            margin-bottom: 22px;
        }

        .subject-label {
            font-size: 11px;
            line-height: 1.4;
            color: #6b7280;
            text-transform: uppercase;
            letter-spacing: 0.7px;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .subject {
            font-size: 16px;
            line-height: 1.4;
            font-weight: bold;
            color: #111827;
        }

        /* ==========================================================
           INTRODUCTION
        ========================================================== */

        .introduction {
            margin-top: 10px;
            margin-bottom: 18px;
            font-size: 14px;
            line-height: 1.6;
            color: #374151;
        }

        /* ==========================================================
           QUOTATION TABLE - ORIGINAL GRADIENT RESTORED
        ========================================================== */

        .quotation-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 12px;
            border: 1px solid #cbd5e1;
            font-size: 13px;
            line-height: 1.45;
        }

        .quotation-table thead th {
            background: linear-gradient(135deg, #172554, #1e3a8a, #2563eb);
            color: #ffffff;
            padding: 12px 10px;
            font-size: 11px;
            line-height: 1.4;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            font-weight: bold;
            border: 1px solid #172554;
        }

        .quotation-table tbody td {
            border-right: 1px solid #e5e7eb;
            border-bottom: 1px solid #e5e7eb;
            padding: 10px 9px;
            vertical-align: top;
            font-size: 13px;
            line-height: 1.45;
        }

        .quotation-table tbody tr:last-child td {
            border-bottom: none;
        }

        .quotation-table tbody td:last-child {
            border-right: none;
        }

        .quotation-table tbody tr:nth-child(even) {
            background: rgba(239, 246, 255, 0.65);
        }

        .sr {
            width: 7%;
            text-align: center;
            font-weight: bold;
        }

        .description {
            width: 58%;
        }

        .qty {
            width: 12%;
            text-align: center;
        }

        .amount {
            width: 23%;
            text-align: right;
        }

        .item-name {
            font-size: 14px;
            line-height: 1.4;
            font-weight: bold;
            color: #111827;
            margin-bottom: 8px;
        }

        .item-description {
            font-size: 13px;
            line-height: 1.45;
        }

        .item-description ul {
            margin: 5px 0 0 18px;
            padding: 0;
        }

        .item-description li {
            margin-bottom: 5px;
            font-size: 13px;
            line-height: 1.45;
            color: #4b5563;
        }

        .qty strong {
            font-size: 14px;
            line-height: 1.4;
        }

        .qty-label {
            font-size: 10px;
            line-height: 1.3;
            color: #9ca3af;
            margin-top: 3px;
        }

        .amount strong {
            font-size: 13px;
            line-height: 1.4;
            color: #111827;
            white-space: nowrap;
        }

        /* ==========================================================
           TOTALS - ORIGINAL GRADIENT RESTORED
        ========================================================== */

        .totals-wrapper {
            width: 100%;
            display: flex;
            justify-content: flex-end;
            margin-top: 14px;
        }

        .totals {
            width: 300px;
            border: 1px solid #cbd5e1;
            font-size: 13px;
        }

        .total-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 9px 13px;
            border-bottom: 1px solid #e5e7eb;
            background: #ffffff;
            font-size: 13px;
            line-height: 1.4;
        }

        .total-row:last-child {
            border-bottom: none;
        }

        .total-label {
            color: #6b7280;
            font-weight: 600;
        }

        .total-value {
            color: #111827;
            font-weight: bold;
        }

        .grand-total {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 12px 13px;
            background: linear-gradient(135deg, #172554, #1e3a8a, #2563eb);
            color: #ffffff;
            font-size: 15px;
            line-height: 1.4;
            font-weight: bold;
        }

        .grand-total span:last-child {
            font-size: 16px;
        }

        /* ==========================================================
           CONTINUED
        ========================================================== */

        .continued {
            margin-top: 35px;
            text-align: right;
            color: #6b7280;
            font-size: 12px;
            line-height: 1.4;
        }

        /* ==========================================================
           SECTION TITLES - ORIGINAL GRADIENT RESTORED (TIGHTER FOR PAGE 2)
        ========================================================== */

        .section-title {
            position: relative;
            font-size: 15px;
            line-height: 1.4;
            font-weight: bold;
            color: #172554;
            padding-bottom: 6px;
            margin-bottom: 10px;
        }

        .section-title::after {
            content: "";
            position: absolute;
            left: 0;
            bottom: 0;
            width: 55px;
            height: 3px;
            border-radius: 4px;
            background: linear-gradient(90deg, #172554, #2563eb, #06b6d4);
        }

        /* ==========================================================
           PRODUCT IMAGE - SMALLER ON PAGE 2
        ========================================================== */

        .product-image-box {
            text-align: center;
            border: 1px solid #cbd5e1;
            border-radius: 6px;
            padding: 8px;
            margin-bottom: 10px;
            background: #ffffff;
        }

        .product-image-box img {
            display: block;
            width: 100%;
            max-width: 300px;
            height: 250px;
            object-fit: contain;
            margin: 0 auto;
            border-radius: 4px;
        }

        .product-image-name {
            font-size: 12px;
            line-height: 1.4;
            font-weight: bold;
            color: #111827;
            margin-top: 5px;
        }

        /* ==========================================================
           TERMS - TIGHTER SPACING FOR PAGE 2
        ========================================================== */

        .terms {
            margin-top: 10px;
        }

        .terms p {
            margin: 3px 0;
            font-size: 14px;
            line-height: 1.45;
            color: #374151;
        }

        .terms strong {
            color: #111827;
        }

        /* ==========================================================
           BANK DETAILS - TIGHTER SPACING FOR PAGE 2
        ========================================================== */

        .bank-section {
            margin-top: 10px;
        }

        .bank-grid {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            margin-top: 6px;
        }

        .bank-card {
            flex: 1 1 calc(50% - 4px);
            min-width: 180px;
            border: 1px solid #cbd5e1;
            border-radius: 4px;
            padding: 6px 10px;
            font-size: 14px;
            line-height: 1.5;
            background: rgba(255, 255, 255, 0.80);
        }

        .bank-name {
            font-size: 12px;
            line-height: 1.4;
            font-weight: bold;
            margin-bottom: 2px;
            color: #172554;
        }

        .bank-label {
            color: #6b7280;
            font-weight: 600;
        }

        /* ==========================================================
           CLOSING - TIGHTER SPACING FOR PAGE 2
        ========================================================== */

        .closing {
            margin-top: 8px;
            font-size: 14px;
            line-height: 1.4;
            color: #374151;
        }

        .closing p {
            margin: 3px 0;
        }

        /* ==========================================================
           SIGNATURE - TIGHTER SPACING FOR PAGE 2
        ========================================================== */

        .signature {
            margin-top: 8px;
            font-size: 14px;
            line-height: 1.4;
        }

        .signature-line {
            margin: 6px 0;
            font-size: 14px;
            line-height: 1.4;
            color: #555;
        }

        .signature-name {
            font-size: 14px;
            line-height: 1.4;
            font-weight: bold;
            color: #111827;
        }

        .mobile {
            float: right;
            font-size: 14px;
            font-weight: bold;
        }

        /* ==========================================================
           PDF CONTROLS - FIXED AT BOTTOM
        ========================================================== */

        #pdf-controls {
            position: fixed;
            bottom: 30px;
            right: 30px;
            z-index: 9999;
            text-align: center;
        }

        #pdf-controls button {
            padding: 14px 32px;
            background: linear-gradient(135deg, #172554, #2563eb);
            color: #fff;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            box-shadow: 0 4px 15px rgba(23, 37, 84, 0.3);
            transition: all 0.3s ease;
        }

        #pdf-controls button:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 25px rgba(23, 37, 84, 0.4);
        }

        /* Loading overlay */
        #loading-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.7);
            z-index: 10000;
            justify-content: center;
            align-items: center;
            flex-direction: column;
        }

        #loading-overlay.show {
            display: flex;
        }

        #loading-overlay .spinner {
            width: 50px;
            height: 50px;
            border: 5px solid #f3f3f3;
            border-top: 5px solid #2563eb;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        #loading-overlay p {
            color: #fff;
            margin-top: 20px;
            font-size: 18px;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }
            100% {
                transform: rotate(360deg);
            }
        }

        /* ==========================================================
           PRINT
        ========================================================== */

        @media print {

            html,
            body {
                width: 210mm;
                margin: 0;
                padding: 0;
                background: #ffffff;
                font-family: Arial, Helvetica, sans-serif;
                display: block;
            }

            #pdf-controls,
            #loading-overlay {
                display: none !important;
            }

            .quotation-page {
                width: 210mm;
                min-height: 297mm;
                margin: 0;
                padding: 13mm 15mm 15mm 15mm;
                box-shadow: none;
                background: linear-gradient(135deg, #ffffff 0%, #f8fbff 48%, #eef5ff 100%) !important;
                border-top: 6px solid #172554 !important;
            }

            #page2 {
                padding: 8mm 13mm 6mm 13mm;
            }

            .header-line {
                display: block !important;
                visibility: visible !important;
                opacity: 1 !important;
                height: 4px !important;
                min-height: 4px !important;
                background: linear-gradient(90deg, #172554 0%, #2563eb 45%, #06b6d4 75%, #94a3b8 100%) !important;
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }

            .subject-line {
                background: linear-gradient(90deg, #172554, #2563eb, #06b6d4) !important;
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }

            .quotation-table thead th {
                background: linear-gradient(135deg, #172554, #1e3a8a, #2563eb) !important;
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }

            .grand-total {
                background: linear-gradient(135deg, #172554, #1e3a8a, #2563eb) !important;
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }

            .section-title::after {
                background: linear-gradient(90deg, #172554, #2563eb, #06b6d4) !important;
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }

            .quotation-page::before,
            .quotation-page::after {
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }

            * {
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }
        }

        @page {
            size: A4;
            margin: 0;
        }
    </style>

</head>

<body>

    <!-- Loading Overlay -->
    <div id="loading-overlay">
        <div class="spinner"></div>
        <p>Generating PDF... Please wait</p>
    </div>

    <?php
    $invoice = $invDetails[0];
    $formattedQuoteDate = !empty($invoice['created'])
        ? date('d-m-Y', strtotime($invoice['created']))
        : '';
    ?>

    <!-- ==========================================================
         PDF CONTENT
    ========================================================== -->

    <div id="pdf-content">

        <!-- ==========================================================
             PAGE 1
        ========================================================== -->

        <div class="quotation-page" id="page1">

            <!-- COMPANY LOGO -->
            <div class="company-header">
                <div class="company-logo">
                    <img src="<?= base_url('public/dist/img/sticker Letter colorpad.png'); ?>" alt="CodeTech Engineers">
                </div>
                <div class="header-line"></div>
            </div>

            <!-- REFERENCE + DATE -->
            <div class="quote-meta">
                <div class="quote-reference">
                    <strong>Ref.: <?= esc($invoice['invid']); ?></strong>
                </div>
                <div class="quote-date">
                    <strong>Date: <?= $formattedQuoteDate; ?></strong>
                </div>
            </div>

            <!-- CUSTOMER -->
            <div class="customer-details">
                <div class="to-label">To,</div>
                <div class="customer-name-old">
                    <strong>M/s. <?= esc($invoice['c_name']); ?></strong>
                </div>
                <div class="customer-address-old">
                    <?php
                    $address = trim($invoice['c_add'] ?? '');
                    if ($address !== '') {
                        $lines = preg_split('/\r\n|\r|\n/', wordwrap($address, 45, "\n"));
                        foreach ($lines as $line) {
                            if (trim($line) !== '') {
                                echo esc(trim($line)) . '<br>';
                            }
                        }
                    }
                    ?>
                </div>
            </div>

            <!-- KIND ATTENTION -->
            <div class="attention">
                <strong>Kind Attn.: Mr.</strong>
            </div>

            <!-- SUBJECT -->
            <div class="subject-section">
                <div class="subject-label">Subject</div>
                <div class="subject">
                    Quotation for <?= esc($cattype); ?> Batch Coding Machines
                </div>
                <div class="subject-line"></div>
            </div>

            <!-- INTRODUCTION -->
            <div class="introduction">
                Dear Sir/Madam,
                <br><br>
                We are pleased to submit our quotation for the following
                batch coding machine as per your requirement.
            </div>

            <!-- PRODUCT TABLE -->
            <table class="quotation-table">
                <thead>
                    <tr>
                        <th class="sr">#</th>
                        <th class="description">Description</th>
                        <th class="qty">Qty.</th>
                        <th class="amount">
                            Amount
                            <br>
                            <small>EXW INR</small>
                        </th>
                    </tr>
                </thead>
                <tbody>

                    <?php
                    $cnt = 1;
                    $extracol = null;
                    $extracol2 = 0;

                    foreach ($itemDetails as $item):

                        if (
                            $item['item_name'] == "Courier" ||
                            $item['item_name'] == "Freight Charges" ||
                            $item['item_name'] == "Wooden Packing" ||
                            $item['item_name'] == "Packing and forwarding"
                        ) {
                            $extracol = $item['item_name'];
                            $extracol2 = $item['total'];
                        }
                    ?>

                        <tr>
                            <td class="sr"><?= $cnt++; ?></td>
                            <td class="description">
                                <div class="item-name"><?= esc($item['item_name']); ?></div>
                                <?php
                                $techData = $item['techs'] ?? '';
                                $features = explode(';', $techData);
                                ?>
                                <?php if (!empty($features)): ?>
                                    <div class="item-description">
                                        <ul>
                                            <?php foreach ($features as $feature):
                                                $feature = trim($feature);
                                            ?>
                                                <?php if ($feature !== ''): ?>
                                                    <li><?= esc(stripcslashes($feature)); ?></li>
                                                <?php endif; ?>
                                            <?php endforeach; ?>
                                        </ul>
                                    </div>
                                <?php endif; ?>
                            </td>
                            <td class="qty">
                                <strong><?= esc($item['quantity']); ?></strong>
                                <div class="qty-label">No.</div>
                            </td>
                            <td class="amount">
                                <strong>
                                    ₹ <?= number_format((float)$item['total'], 2, '.', ','); ?>
                                </strong>
                            </td>
                        </tr>

                    <?php endforeach; ?>

                </tbody>
            </table>

            <!-- TOTALS -->
            <div class="totals-wrapper">
                <div class="totals">

                    <?php if (!empty($extracol)): ?>
                        <div class="total-row">
                            <span class="total-label"><?= esc($extracol); ?></span>
                            <span class="total-value">
                                ₹ <?= number_format((float)$extracol2, 2, '.', ','); ?>
                            </span>
                        </div>
                    <?php endif; ?>

                    <div class="total-row">
                        <span class="total-label">
                            GST <?= number_format((float)($invoice['taxrate'] ?? 18), 2); ?>%
                        </span>
                        <span class="total-value">
                            ₹ <?= number_format((float)$invoice['taxamount'], 2, '.', ','); ?>
                        </span>
                    </div>

                    <div class="grand-total">
                        <span>TOTAL</span>
                        <span>
                            ₹ <?= number_format((float)$invoice['totalamount'], 2, '.', ','); ?>
                        </span>
                    </div>

                </div>
            </div>

            <!-- CONTINUED -->
            <div class="continued">
                <strong>Continued on next page...</strong>
            </div>

        </div>

        <!-- ==========================================================
             PAGE 2 - EXTRA TIGHT SPACING TO FIT ALL CONTENT
        ========================================================== -->

        <div class="quotation-page" id="page2">

            <!-- PRODUCT DETAILS -->
            <div class="section-title">Product Details</div>

            <?php foreach ($itemDetails as $item): ?>
                <?php if (!empty($item['img_loc'])): ?>
                    <div class="product-image-box">
                        <img src="<?= base_url('public/dist/img/' . $item['img_loc']); ?>" alt="<?= esc($item['item_name']); ?>">
                        <div class="product-image-name"><?= esc($item['item_name']); ?></div>
                    </div>
                <?php endif; ?>
            <?php endforeach; ?>

            <!-- TERMS & CONDITIONS -->
            <div class="terms">
                <div class="section-title">Terms & Conditions</div>

                <p>
                    <strong>A.</strong>
                    Above prices are Ex-Works Ahmedabad.
                    Transportation charges are extra.
                </p>

                <p>
                    <strong>B. Payment Terms:</strong>
                    50% Advance along with confirmed P.O. and balance
                    50% against Proforma Invoice before dispatch after
                    inspection.
                </p>

                <p>
                    <strong>C. Delivery:</strong>
                    Within 3–4 weeks from the date of receipt of confirmed
                    P.O. along with advance.
                </p>

                <p>
                    <strong>D. Installation:</strong>
                    Installation will be provided free of cost from our side.
                </p>

                <p>
                    <strong>E.</strong>
                    The design and prices are subject to change for any
                    changes/additions in the above specifications.
                </p>

                <p>
                    <strong>F. Warranty:</strong>
                    1 year from the date of delivery against manufacturing
                    defects. The warranty covers free replacement of
                    defective parts, if any.
                </p>

                <p>
                    <strong>G.</strong>
                    Order once placed cannot be cancelled under any
                    circumstances. In case of cancellation, the entire
                    amount of advance payment will stand forfeited.
                </p>
            </div>

            <!-- BANK DETAILS -->
            <div class="bank-section">
                <div class="section-title">Bank Details</div>

                <div class="bank-grid">
                    <?php foreach ($bankDetails as $bank): ?>
                        <div class="bank-card">
                            <div>
                                <span class="bank-label">Account Name:</span>
                                Codetech Engineers
                            </div>
                            <div class="bank-name">
                                <span class="bank-label">Bank Name:</span>
                                <?= esc($bank['bname']); ?>
                            </div>
                            <div>
                                <span class="bank-label">A/C No:</span>
                                <?= esc($bank['ac']); ?>
                            </div>
                            <div>
                                <span class="bank-label">IFSC:</span>
                                <?= esc($bank['ifsc']); ?>
                            </div>
                            <div>
                                <span class="bank-label">Branch:</span>
                                <?= esc($bank['branch']); ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- CLOSING -->
            <div class="closing">
                <p>
                    We hope that the above offer is technically in line
                    with your requirement.
                </p>
                <p>
                    Thanking you and looking forward to receiving your
                    valuable Purchase Order.
                </p>
            </div>

            <!-- SIGNATURE -->
            <div class="signature">
                <div>Yours truly,</div>
                <div style="margin-top:6px;">
                    <strong>From CodeTech Engineers</strong>
                </div>
                <div class="signature-line">-----sd------</div>
                <div class="signature-name">
                    Kamlesh Chavda
                    <span class="mobile">Mob.: +91-9737693302</span>
                </div>
            </div>

        </div>

    </div>

    <!-- ==========================================================
         PDF CONTROLS
    ========================================================== -->

    <div id="pdf-controls">
        <button id="downloadPdfBtn">
            <i class="fa fa-file-pdf-o"></i> Download PDF
        </button>
    </div>

    <!-- ==========================================================
         SCRIPTS
    ========================================================== -->

    <script src="https://code.jquery.com/jquery-3.6.0.min.js">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js">
    </script>

    <script>
        $(document).ready(function() {

            $('#downloadPdfBtn').on('click', function() {

                // Show loading overlay
                $('#loading-overlay').addClass('show');

                var invId = <?= json_encode($invoice['invid']); ?>;
                var pages = document.querySelectorAll('.quotation-page');
                var pdf = new jspdf.jsPDF({
                    unit: 'mm',
                    format: 'a4',
                    orientation: 'portrait'
                });

                var promises = [];

                // Capture each page separately
                pages.forEach(function(page, index) {
                    var promise = html2canvas(page, {
                        scale: 2,
                        useCORS: true,
                        allowTaint: true,
                        logging: false,
                        backgroundColor: '#ffffff',
                        width: 794,
                        height: 1123,
                        windowWidth: 794,
                        windowHeight: 1123,
                        onclone: function(clonedDoc) {
                            var images = clonedDoc.querySelectorAll('img');
                            var imgPromises = [];
                            images.forEach(function(img) {
                                if (!img.complete) {
                                    imgPromises.push(new Promise(function(resolve) {
                                        img.onload = resolve;
                                        img.onerror = resolve;
                                    }));
                                }
                            });
                            return Promise.all(imgPromises);
                        }
                    }).then(function(canvas) {
                        var imgData = canvas.toDataURL('image/jpeg', 0.95);
                        return {
                            imgData: imgData,
                            index: index
                        };
                    });

                    promises.push(promise);
                });

                Promise.all(promises).then(function(results) {
                    results.sort(function(a, b) {
                        return a.index - b.index;
                    });

                    results.forEach(function(result, index) {
                        if (index > 0) {
                            pdf.addPage('a4');
                        }
                        pdf.addImage(result.imgData, 'JPEG', 0, 0, 210, 297);
                    });

                    $('#loading-overlay').removeClass('show');
                    pdf.save('Quotation-' + invId + '.pdf');

                }).catch(function(error) {
                    console.error('Error generating PDF:', error);
                    $('#loading-overlay').removeClass('show');
                    alert('Error generating PDF. Please try again.');
                });

            });

        });
    </script>

</body>

</html>