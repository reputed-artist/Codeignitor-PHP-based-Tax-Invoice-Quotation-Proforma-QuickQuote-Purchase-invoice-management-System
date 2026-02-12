
  
function getExportButtons(tableId, exportColumns) {
    return [
        {
            extend: 'copyHtml5',
            text: '&nbsp;<i class="fa fa-files-o">&nbsp; Copy </i>',
            className: "btn-sm btn btn-danger",
            footer: true,
            titleAttr: 'Copy',
            exportOptions: {
                columns: exportColumns
            }
        },
        {
            text: '&nbsp;{ } &nbsp; JSON',
            className: "btn-sm btn btn-danger",
            titleAttr: 'JSON',
            exportOptions: {
                columns: exportColumns
            },
            action: function (e, dt, button, config) {
                var data = dt.buttons.exportData();
                $.fn.dataTable.fileSave(
                    new Blob([JSON.stringify(data)]),
                    'Export.json'
                );
            }
        },
        {
            extend: 'excelHtml5',
            text: '&nbsp;<i class="fa fa-file-excel-o">&nbsp; Excel</i>',
            className: "btn-sm btn btn-danger",
            titleAttr: 'Excel',
            footer: true,
            title: 'AdminLT || Clients Data',
              exportOptions: {
        columns: ':visible'
    },
    customize: function(xlsx) {
        // Debug: Save the raw XML to see what's being generated
        console.log('Excel XML structure:', xlsx.xl.worksheets['sheet1.xml']);
        
        var sheet = xlsx.xl.worksheets['sheet1.xml'];
        var $sheet = $(sheet);
        
        // Get all rows
        var $rows = $sheet.find('row');
        console.log('Total rows in sheet:', $rows.length);
        
        // Get closing balance
        var closingBalance = $("#totalclosingamt").text();
        console.log('Closing balance from DOM:', closingBalance);
        
        // Create simple closing balance row
        var lastRowNum = $rows.length + 1;
        var closingRow = '<row r="' + lastRowNum + '">' +
            '<c r="D' + lastRowNum + '" t="inlineStr"><is><t>Closing Balance</t></is></c>' +
            '<c r="F' + lastRowNum + '" t="n"><v>' + (parseFloat(closingBalance.replace(/,/g, '')) || 0) + '</v></c>' +
            '</row>';
        
        // Insert before the closing </sheetData>
        var sheetData = $sheet.find('sheetData');
        sheetData.append(closingRow);
        
        // Force sheet to recalc
        $sheet.find('dimension').attr('ref', 'A1:G' + lastRowNum);
    },
    filename: 'Ledger_Report_' + new Date().toISOString().slice(0, 10)
},
      {
            extend: 'csvHtml5',
            text: '&nbsp;<i class="fa fa-file-text-o">&nbsp; CSV</i>',
            className: "btn-sm btn btn-danger",
            titleAttr: 'CSV',
            footer: true,
            title: 'AdminLT || Clients Data',
            exportOptions: {
                columns: exportColumns
            }
        },
        // {
        //     extend: 'pdfHtml5',
        //     text: '&nbsp;<i class="fa fa-file-pdf-o">&nbsp; PDF</i>',
        //     className: "btn-sm btn btn-danger",
        //     orientation: 'landscape',
        //     pageSize: 'A3',
        //     titleAttr: 'PDF',
        //     footer: true,
        //     title: 'AdminLT || Clients Data',
        //     customize: function (doc) {
        //         doc.pageMargins = [10, 10, 10, 10];
        //         doc.defaultStyle.fontSize = 7;
        //         doc.styles.tableHeader.fontSize = 7;
        //         doc.styles.tableFooter.fontSize = 15;
        //         doc.styles.title.fontSize = 15;

        //         doc['footer'] = function (page, pages) {
        //             return {
        //                 columns: [
        //                     {
        //                         alignment: 'center',
        //                         text: ['Clients Data from CodeTech Engineers'],
        //                     },
        //                     {
        //                         alignment: 'right',
        //                         text: ['page ', { text: page.toString() }, ' of ', { text: pages.toString() }],
        //                     }
        //                 ],
        //                 margin: [10, 0]
        //             };
        //         };

        //         var objLayout = {};
        //         objLayout['hLineWidth'] = function () { return .5; };
        //         objLayout['vLineWidth'] = function () { return .5; };
        //         objLayout['hLineColor'] = function () { return '#aaa'; };
        //         objLayout['vLineColor'] = function () { return '#aaa'; };
        //         objLayout['paddingLeft'] = function () { return 4; };
        //         objLayout['paddingRight'] = function () { return 4; };
        //         doc.content[1].layout = objLayout;
        //         doc.content[1].table.widths = Array(doc.content[1].table.body[0].length + 1).join('*').split('');
        //         doc.defaultStyle.alignment = 'center';
        //         doc.styles.tableHeader.alignment = 'center';
        //     },
        //     exportOptions: {
        //         columns: exportColumns
        //     }
        // },
 {
    extend: 'pdfHtml5',
    text: '&nbsp;<i class="fa fa-file-pdf-o">&nbsp; PDF</i>',
    className: "btn-sm btn btn-danger",
    orientation: 'portrait',
    pageSize: 'A4',
    titleAttr: 'PDF',
    // Set title to empty string to prevent default
    title: '',
    
    customize: function (doc) {
        // ========== COMPLETELY DISABLE DEFAULT TITLE ==========
        // Remove any default title that might have been added
        doc.header = null;
        
        // ========== CREATE CUSTOM HEADER ==========
        // First, let's see what .box-title actually contains
        var boxTitleText = $("#Company").text() || "";
                var boxTitleText2 = $("#Location").text() || "";
        console.log("Box Title Text:", boxTitleText);
        

        var openingBalance = $("#opening_bal").text().replace('Opening Balance: ', '') || "0.00";

        // Parse the box title to extract company and client
        var companyName = "";
        var clientName = "";
        var fy = $("#selectFY").val() || "Current FY";
        
        // Try to extract from box-title (assuming format: "Company - Client Name Ledger")
        if (boxTitleText.includes('-')) {
            var parts = boxTitleText.split('-');
            companyName = parts[0].trim();
            
            // Remove "Ledger" from client name if present
            var clientPart = parts[1] || "";
            clientName = clientPart.replace(/Ledger/gi, '').trim();
        } else {
            // If no dash, use the whole text as company name
            companyName = boxTitleText;
            clientName = boxTitleText2;
        }
        
        // Fallback if empty
        if (!companyName) {
            companyName = "<?= isset($companyInfo->company_name) ? $companyInfo->company_name : 'Company'; ?>";
        }
        
        if (!clientName) {
            clientName = "<?= isset($clientInfo->name) ? $clientInfo->name : 'Client'; ?>";
        }
        
        // ========== CREATE CUSTOM HEADER CONTENT ==========
        var customHeader = [
            {
                text: companyName,
                style: 'companyHeader',
                alignment: 'center',
                margin: [0, 10, 0, 5]
            },
            {
                text: clientName,
                style: 'clientHeader',
                alignment: 'center',
                margin: [0, 0, 0, 5]
            },
            {
                text: 'Financial Year: ' + fy,
                style: 'fyHeader',
                alignment: 'center',
                margin: [0, 0, 0, 10]
            },
      // Opening Balance - Positioned to align with table's Balance column
            {
                columns: [
                    // Empty space on left
                    {
                        text: '',
                        width: '70%'  // Adjust this to move the box left/right
                    },
                    // Opening Balance Box
                    {
                        text:'',
                        width: '30%'  // Box takes remaining space
                    }
                ],
                margin: [0, 0, 0, 20]
            },
    
            {
                columns: [
                    {
                        text: 'Generated on: ' + new Date().toLocaleDateString('en-IN', {
                            day: '2-digit',
                            month: 'short',
                            year: 'numeric',
                            hour: '2-digit',
                            minute: '2-digit'
                        }),
                        alignment: 'left',
                        fontSize: 7,
                        margin: [0, 0, 0, 5]
                    },
                    {
                        table: {
                            widths: ['*'],
                            body: [
                                [
                                    {
                                        text: 'Opening Balance: ' + openingBalance,
                                        style: 'openingBalanceBox',
                                        alignment: 'center'
                                    }
                                ]
                            ]
                        },
                        layout: {
                            hLineWidth: function(i, node) {
                                return 1;
                            },
                            vLineWidth: function(i, node) {
                                return 1;
                            },
                            hLineColor: function(i, node) {
                                return '#3498db';
                            },
                            vLineColor: function(i, node) {
                                return '#3498db';
                            }
                        },
                        width: '30%'  // Box takes remaining space
                    }
                    // {
                    //     text: '', // Will be updated by footer
                    //     alignment: 'right',
                    //     fontSize: 7,
                    //     margin: [0, 0, 0, 5]
                    // }
                ],
                margin: [0, 0, 0, 10]
            }
        ];
        
        // ========== REPLACE THE ENTIRE DOCUMENT CONTENT ==========
        // Save the table data
        var tableData = null;
        if (doc.content && doc.content.length > 0) {
            // Find the table in the content
            for (var i = 0; i < doc.content.length; i++) {
                if (doc.content[i] && doc.content[i].table) {
                    tableData = doc.content[i];
                    break;
                }
            }
        }
        
        // Start with empty content
        doc.content = [];
        
        // Add custom header
        doc.content = customHeader;
        
        // Add table if found
        if (tableData) {
            doc.content.push(tableData);
        }
        
        // ========== DOCUMENT STYLING ==========
        doc.pageMargins = [5, 20, 5, 10];
        
        // Define custom styles
        doc.styles = {
            companyHeader: {
                fontSize: 16,
                bold: true,
                color: '#2c3e50'
            },
            clientHeader: {
                fontSize: 14,
                bold: true,
                color: '#34495e'
            },
            fyHeader: {
                fontSize: 12,
                bold: true,
                color: '#7f8c8d'
            },
            tableHeader: {
                fontSize: 8,
                bold: true,
                fillColor: '#2c3e50',
                color: 'white',
                alignment: 'center'
            }
        };
        
        doc.defaultStyle = {
            fontSize: 8,
            alignment: 'left'
        };
        
        // ========== TABLE CUSTOMIZATION ==========
        if (tableData) {
            var objLayout = {};
            objLayout['hLineWidth'] = function () { return .3; };
            objLayout['vLineWidth'] = function () { return .3; };
            objLayout['hLineColor'] = function () { return '#aaa'; };
            objLayout['vLineColor'] = function () { return '#aaa'; };
            tableData.layout = objLayout;
            
            // Column widths for full page
            var availableWidth = 575;
            var columnWidths = [
                availableWidth * 0.05,
                availableWidth * 0.10,
                availableWidth * 0.15,
                availableWidth * 0.15,
                availableWidth * 0.15,
                availableWidth * 0.15,
                availableWidth * 0.15
            ];
            
            tableData.table.widths = columnWidths;
            tableData.width = '100%';
            
            // Get values for footer
            var totalCredit = $("#totalcreditamt").text() || "0.00";
            var totalDebit = $("#totaldebitamt").text() || "0.00";
            var closingBalance = $("#totalclosingamt").text() || "0.00";
            
            // Add footer rows
            var columnCount = 7;
            var emptyRow = Array(columnCount).fill({ text: '' });
            tableData.table.body.push(emptyRow);
            
            // Footer row 1
            var footerRow1 = [];
            for (var i = 0; i < columnCount; i++) {
                if (i === 3) {
                    footerRow1.push({ 
                        text: 'Total Bal. Credit & Debit', 
                        bold: true, 
                        fillColor: '#f2f2f2'
                    });
                } else if (i === 4) {
                    footerRow1.push({ 
                        text: totalCredit, 
                        bold: true, 
                        fillColor: '#f2f2f2', 
                        alignment: 'right' 
                    });
                } else if (i === 5) {
                    footerRow1.push({ 
                        text: totalDebit, 
                        bold: true, 
                        fillColor: '#f2f2f2', 
                        alignment: 'right' 
                    });
                } else {
                    footerRow1.push({ 
                        text: '', 
                        fillColor: '#f2f2f2' 
                    });
                }
            }
            
            // Footer row 2
            var footerRow2 = [];
            for (var i = 0; i < columnCount; i++) {
                if (i === 4) {
                    footerRow2.push({ 
                        text: 'Closing Balance', 
                        bold: true, 
                        fillColor: '#e6f7ff' 
                    });
                } else if (i === 5) {
                    footerRow2.push({ 
                        text: closingBalance, 
                        bold: true, 
                        fillColor: '#e6f7ff', 
                        alignment: 'right' 
                    });
                } else {
                    footerRow2.push({ 
                        text: '', 
                        fillColor: '#e6f7ff' 
                    });
                }
            }
            
            tableData.table.body.push(footerRow1);
            tableData.table.body.push(footerRow2);
        }
        
        // ========== PAGE FOOTER ==========
        doc['footer'] = function (currentPage, pageCount) {
            return {
                columns: [
                    {
                        alignment: 'left',
                        text: 'Generated on: ' + new Date().toLocaleDateString(),
                        fontSize: 7
                    },
                    {
                        alignment: 'right',
                        text: 'Page ' + currentPage + ' of ' + pageCount,
                        fontSize: 7
                    }
                ],
                margin: [5, 5, 5, 0]
            };
        };
    },
    
    exportOptions: {
        columns: ':visible'
    },
    
    filename: function() {
        var fy = $("#selectFY").val() || "FY";
        var clientName = $("#Company").text();
        var date = new Date().toISOString().slice(0, 10);
        return clientName + '_Ledger_FY_' + fy + '_' + date + '.pdf';
    }
},
        {
            extend: 'print',
            text: '&nbsp;<i class="fa fa-print">&nbsp; Print</i>',
            className: "btn btn-sm btn-danger",
            titleAttr: 'Print',
            footer: true,
            title: 'AdminLT || Clients Data',
               exportOptions: {
        columns: exportColumns,
        // 👇 Don't include tfoot automatically
        modifier: {
            page: 'all'
        },
        stripHtml: false
    },
    customize: function (win) {
        // Remove tfoot from auto-printing
        $(win.document.body).find('tfoot').remove();

        // Clone and append tfoot as last row in tbody
        var tfootRow = $('#example tfoot tr').clone();
        if (tfootRow.length) {
            var footerCells = '';
            tfootRow.find('th, td').each(function () {
                footerCells += '<td style="font-weight:bold; text-align:center;">' + $(this).text().trim() + '</td>';
            });

            $(win.document.body).find('table tbody').append('<tr>' + footerCells + '</tr>');
        }

        // Optional styling
        $(win.document.body).css('font-size', '10pt').find('table')
            .addClass('compact')
            .css('font-size', 'inherit');
    }
},

        {
            className: "btn btn-sm btn-danger",
            titleAttr: 'TXT',
            text: '<i class="fa fa-fw fa-file-text-o">&nbsp; TXT</i>',
            action: function (e, dt, node, config) {
                doExport(tableId, { type: 'txt' });
            }
        },
        {
            className: "btn btn-sm btn-danger",
            titleAttr: 'SQL',
            text: '<i class="fa fa-fw fa-database">&nbsp; SQL</i>',
            action: function (e, dt, node, config) {
                doExport(tableId, { type: 'sql' });
            },
            exportOptions: {
                modifier: {
                    page: 'all'
                },
                columns: exportColumns
            }
        },
        {
            className: "btn btn-sm btn-danger",
            titleAttr: 'Doc',
            text: '<i class="fa fa-fw fa-file-word-o">&nbsp; Docx</i>',
            footer: true,
            action: function (e, dt, node, config) {
                doExport(tableId, { type: 'doc', mso: { pageOrientation: 'landscape' } });
            },
            exportOptions: {
                modifier: {
                    page: 'all'
                },
                columns: exportColumns
            }
        },
        {
            className: "btn btn-sm btn-danger",
            titleAttr: 'PNG',
            footer: true,
            text: '<i class="fa fa-fw fa-image">&nbsp; PNG</i>',
            action: function (e, dt, node, config) {
                doExport(tableId, { type: 'png' });
            },
            exportOptions: {
                modifier: {
                    page: 'all'
                },
                columns: exportColumns
            }
        }
    ];
}
