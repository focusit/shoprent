Transaction Table 
    property_type == agreement_id  (change name)
    previous_balance == amount (change name)
    transaction_number can be null
    shop_id  (added)
    bill_no (added)

Bills Table
    ADD  tax(float) , prevbal(float) ,total_bal(float)

billingsetting.json
    "month":"08","year":"2024","billcycle":"monthly",(add)

17 August,2024
    -at login alert admin if now()>=billing_data
    -Bill-> paid bills (view)

20 August,2024
    -Print (bills) -last payment from transaction table where month is $bill->month -1
    -if this month bills generated last bills paybill button disable
    -Payment(search)-only last bill per $agreement_id
    -allocation form -rent from shopRent Table
    -indexcontroller -dashboard() ->if agreement valid_date < now (status inactive in agreement table)
            and shop status vacant
    -all tables -user_id column created (added in migration and models)
            (bills, tenants, shoprent, transaction, agreement)
    
21 August,2024
    -Partial Payments data Concatenate
    -Agreement -last bill(button) ->show bill details
    -All tables- at created and updated at -user_id saved

22 August,2024
    -Regenerate Bills

23 August,2024
24 August,2024
25 August,2024
26 August,2024
27 August,2024
28 August,2024
29 August,2024
30 August,2024
31 August,2024




<div class="col-sm-12 col-md-6">
                    <div class="dt-buttons btn-group flex-wrap">
                        <button class="btn btn-secondary buttons-copy buttons-html5"   onclick="selectElementContents( document.getElementById('tableId') );" tabondex="0" aria-control="example1" type="button">
                            <span>Copy</span>
                        </button>
                        <button class="btn btn-secondary buttons-csv buttons-html5" onclick="tableToCSV();" tabondex="0" aria-control="example1" type="button">
                            <span>CSV</span>
                        </button><!-- comment -->
                        <button class="btn btn-secondary buttons-excel buttons-html5" id="btnExport" tabondex="0" aria-control="example1" type="button">
                            <span>Excel</span>
                        </button><!-- comment -->
                        <button class="btn btn-secondary buttons-pdf buttons-html5" onclick="Export();" tabondex="0" aria-control="example1" type="button">
                            <span>Pdf</span>
                        </button><!-- comment -->
                        <button class="btn btn-secondary buttons-print" onclick="printData();" tabondex="0" aria-control="example1" type="button">
                            <span>Print</span>
                        </button>
                        <div class="btn-group">
                            <button class="btn btn-secondary buttons-collection dropdown-toggle buttons-colvis" tabondex="0" aria-control="example1" type="button" aria-haspopup="true">
                                <span>Column visibility</span>
                                <span class="dt-down-arrow"></span>
                                
                            </button>
                        </div>
          
                    </div>
                </div>
                <div class="col-sm-12 col-md-6">
                    <div id="example1_filter" class="dataTables_filter text-right ">
                        <label>
                            search:<input type="search" class="form-control form-control-sm form-inline" id="myInput" onkeyup="searchTable();" placeholder aria-controls="example1">
                        </label>
                    </div>
                </div>
            </div>
<script>

function selectElementContents(el) {
        var body = document.body, range, sel;
        if (document.createRange && window.getSelection) {
            range = document.createRange();
            sel = window.getSelection();
            sel.removeAllRanges();
            try {
                range.selectNodeContents(el);
                sel.addRange(range);
            } catch (e) {
                range.selectNode(el);
                sel.addRange(range);
            }
        } else if (body.createTextRange) {
            range = body.createTextRange();
            range.moveToElementText(el);
            range.select();
        }
    }//copy table
 
 
       function tableToCSV() {

           // Variable to store the final csv data
           var csv_data = [];

           // Get each row data
           var rows = document.getElementsByTagName('tr');
           for (var i = 0; i < rows.length; i++) {

               // Get each column data
               var cols = rows[i].querySelectorAll('td,th');

               // Stores each csv row data
               var csvrow = [];
               for (var j = 0; j < cols.length; j++) {

                   // Get the text data of each cell
                   // of a row and push it to csvrow
                   csvrow.push(cols[j].innerHTML);
               }

               // Combine each column value with comma
               csv_data.push(csvrow.join(","));
           }

           // Combine each row data with new line character
           csv_data = csv_data.join('\n');

           // Call this function to download csv file 
           downloadCSVFile(csv_data);

       }

       function downloadCSVFile(csv_data) {

           // Create CSV file object and feed
           // our csv_data into it
           CSVFile = new Blob([csv_data], {
               type: "text/csv"
           });

           // Create to temporary link to initiate
           // download process
           var temp_link = document.createElement('a');

           // Download csv file
           temp_link.download = "data.csv";
           var url = window.URL.createObjectURL(CSVFile);
           temp_link.href = url;

           // This link should not be displayed
           temp_link.style.display = "none";
           document.body.appendChild(temp_link);

           // Automatically click the link to
           // trigger download
           temp_link.click();
           document.body.removeChild(temp_link);
       }//CSV file
       
        function Export() {
            html2canvas(document.getElementById('tableId'), {
                onrendered: function (canvas) {
                    var data = canvas.toDataURL();
                    var docDefinition = {
                        content: [{
                            image: data,
                            width: 500
                        }]
                    };
                    pdfMake.createPdf(docDefinition).download("Table.pdf");
                }
            });
        }//pdf 
       
function printData(){
  var divToPrint=document.getElementById("tableId");
  newWin= window.open("");
  newWin.document.write(divToPrint.outerHTML);
  newWin.print();
  newWin.close();
}//print

function searchTable() {
   var input, filter, found, table, tr, td, i, j;
   input = document.getElementById("myInput");
   filter = input.value.toUpperCase();
   table = document.getElementById("tableId");
   tr = table.getElementsByTagName("tr");
   for (i = 0; i < tr.length; i++) {
       td = tr[i].getElementsByTagName("td");
       for (j = 0; j < td.length; j++) {
           if (td[j].innerHTML.toUpperCase().indexOf(filter) > -1) {
               found = true;
           }
       }
       if (found) {
           tr[i].style.display = "";
           found = false;
       } else {
           tr[i].style.display = "none";
       }
   }
}//search
</script>
