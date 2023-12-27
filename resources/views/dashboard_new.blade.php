@extends('masterlist')

@section('title', 'Dashboard')

@section('body')


    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <!-- .container-fluid -->
            <div class="container-fluid">
            </div>
            <!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <!-- Info boxes -->
                <div class="row">

                    <!--.col -->
                    <div class="col-12 col-sm-6 col-md-3">
                        <div class="info-box bg-gradient-danger mb-3">
                            <span class="info-box-icon elevation-1 bg-warning"><i class="fas fa-shopping-bag"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Shop</span>
                                <span class="info-box-number">{{ DB::table('shop_rents')->count() }}</span>
                            </div>
                        </div>
                    </div>
                    <!-- /.col -->

                    <!--.col -->
                    <div class="col-12 col-sm-6 col-md-3">
                        <div class="info-box mb-3 bg-gradient-danger">
                            <span class="info-box-icon  elevation-1 bg-warning"><i class="fas fa-user-friends"></i></span>

                            <div class="info-box-content">
                                <span class="info-box-text">Tenants</span>
                                <span class="info-box-number">{{ DB::table('tenants')->count() }}</span>
                            </div>
                        </div>
                    </div>
                    <!-- /.col -->

                    <!-- fix for small devices only -->
                    <div class="clearfix hidden-md-up"></div>
                    <!--.col -->
                    <div class="col-12 col-sm-6 col-md-3">
                        <div class="info-box bg-gradient-danger mb-3">
                            <span class="info-box-icon bg-warning  elevation-1"><i class="fas fa-coins"></i></span>

                            <div class="info-box-content">
                                <span class="info-box-text">Bills</span>
                                <span class="info-box-number">{{ DB::table('bills')->count() }}</span>
                            </div>
                        </div>
                    </div>
                    <!-- /.col -->
                    <!--.col -->
                    <div class="col-12 col-sm-6 col-md-3">
                        <div class="info-box mb-3 bg-gradient-danger">
                            <span class="info-box-icon bg-warning  elevation-1"><i class="fas fa-credit-card"></i></span>

                            <div class="info-box-content">
                                <span class="info-box-text">Payment</span>
                                <span class="info-box-number">41,410</span>
                            </div>
                        </div>
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /Info boxes -->

                <!-- Main row -->
                <div class="row" id="dashboard-cards">

                </div>

            </div>
        </section>
    </div>
    <!-- /.content-wrapper. Contains page content -->

    <script>
      // Load JSON data from the file
      fetch('./dashboard-cards.json')
          .then(response => {
              if (!response.ok) {
                  throw new Error('Network response was not ok');
              }
              return response.json();
          })
          .then(cards => {
              console.log('Successfully loaded JSON data:', cards);
  
              const dashboardCardsElement = document.getElementById('dashboard-cards');
  
              cards.forEach(card => {
                  const cardHtml = `
                      <div class="col-md-6">
                          <div class="card">
                              <div class="card-header">
                                  <h3>${card.title}</h3>
                              </div>
                              <div class="card-body">
                                  <p>${card.body}</p>
                              </div>
                              <div class="card-footer">
                                  <a href="${card.linkCreate}">Add ${card.linkTextCreate}</a>
                                  <a href="${card.linkView}">View ${card.linkTextView}</a>
                              </div>
                          </div>
                      </div>
                  `;
  
                  dashboardCardsElement.innerHTML += cardHtml;
              });
          })
          .catch(error => console.error('Error loading dashboard cards:', error));
  </script>
@endsection
