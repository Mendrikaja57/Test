<!DOCTYPE html>
<html>

<head>
    <title>Statistiques</title>
    <link rel="stylesheet" href="{{asset('bootstrap.min.css')}}">
    <style>
        .table-sm {
            font-size: 0.8rem;
        }

        .statistic {
            margin-top: 20px;
        }
    </style>
    <script src="{{asset('chart.js')}}"></script>

    <script src="{{asset('jspdf.debug.js')}}"></script>
</head>

<body>
    <div>
        <canvas id="myChart"></canvas>
    </div>

    <div>
        <canvas id="beneficesPV"></canvas>
    </div>

    <script>
        const ctx = document.getElementById('myChart');

new Chart(ctx, {
  type: 'bar',
  data: {
    labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
    datasets: [{
      label: '# of Votes',
      data: [12, 19, 3, 5, 2, 3],
      borderWidth: 1
    }]
  },
  options: {
    scales: {
      y: {
        beginAtZero: true
      }
    }
  }
});
    </script>


    <a href="#" onclick="export_pdf(event)" data-canvas="myStat" data-gap="0" data-title="Mon Titre">Exporter en
        PDF</a>


    <script>
        function export_pdf(event) {
            const doc = new jsPDF();

            // Exporter le premier canvas (myStat)
            const canvas1 = document.getElementById('myChart');
            const image_data1 = canvas1.toDataURL('image/png', 1.0);
            const img1Width = doc.internal.pageSize.getWidth() * 0.8; // Ajustez la largeur de l'image selon vos besoins
            const img1Height = (canvas1.height / canvas1.width) * img1Width;
            doc.addImage(image_data1, 'PNG', 10, 10, img1Width, img1Height);

            // Exporter le deuxième canvas (beneficesPV)
            const canvas2 = document.getElementById('beneficesPV');
            const image_data2 = canvas2.toDataURL('image/png', 1.0);
            const img2Width = doc.internal.pageSize.getWidth() * 0.8; // Ajustez la largeur de l'image selon vos besoins
            const img2Height = (canvas2.height / canvas2.width) * img2Width;
            doc.addImage(image_data2, 'PNG', 10, img1Height + 20, img2Width, img2Height);

            // Enregistrer le fichier PDF
            doc.save('graphiques.pdf');
        }
    </script>

</body>

</html>
