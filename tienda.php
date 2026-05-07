<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Tienda - Peluquería Asier</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { background: #1a1d20; color: white; font-family: 'Segoe UI', sans-serif; }
        .product-card {
            background: rgba(255,255,255,0.05);
            border: 1px solid rgba(255,255,255,0.1);
            border-radius: 15px;
            transition: 0.3s;
            height: 100%;
            display: flex;
            flex-direction: column;
        }
        .product-card:hover { 
            transform: translateY(-10px); 
            border-color: #ffc107; 
            box-shadow: 0 15px 30px rgba(0,0,0,0.5); 
        }
        .img-container {
            background: white; 
            border-radius: 10px; 
            padding: 15px;
            height: 220px; 
            display: flex; 
            align-items: center; 
            justify-content: center;
            margin-bottom: 15px;
        }
        .img-container img { max-height: 100%; max-width: 100%; object-fit: contain; }
        .price-tag { font-size: 1.4rem; color: #ffc107; font-weight: bold; margin: 10px 0; }
        .product-title { font-size: 1.1rem; font-weight: 600; height: 50px; overflow: hidden; }
        
        /* Estilo Paginación */
        .pagination .page-link { background: #212529; border: 1px solid #333; color: #ffc107; cursor: pointer; }
        .pagination .page-item.active .page-link { background: #ffc107; border-color: #ffc107; color: black; }

        /* Ajuste para que la lupa y el input se vean como uno solo */
        .search-container .input-group-text {
            border-left: none;
            cursor: pointer;
            transition: 0.2s;
        }
        .search-container .input-group-text:hover {
            background: #333 !important;
        }
        .search-container input {
            border-right: none;
        }
    </style>
</head>
<body>

<?php include 'navbar.php'; ?>

<div class="container mt-5 pt-4">
    <div class="row mb-5 align-items-center">
        <div class="col-md-8">
            <h1 class="fw-bold text-warning"><i class="fas fa-store me-2"></i>Productos Recomendados</h1>
            <p class="text-white-50">Productos originales utilizados en nuestras sesiones de estilismo.</p>
        </div>
        <div class="col-md-4">
            <div class="input-group search-container">
                <input type="text" id="searchInput" class="form-control bg-dark text-white border-secondary" placeholder="Buscar producto..." onkeyup="resetAndRender()">
                <span class="input-group-text bg-dark border-secondary text-warning" onclick="resetAndRender()">
                    <i class="fas fa-search"></i>
                </span>
            </div>
        </div>
    </div>

    <div class="row row-cols-1 row-cols-md-3 row-cols-lg-4 g-4" id="productsGrid"></div>

    <nav class="mt-5">
        <ul class="pagination justify-content-center" id="pagination"></ul>
    </nav>
</div>

<script>
const products = [
    { title: "American Crew Fiber - Cera Mate", price: "", 
    image: "https://m.media-amazon.com/images/I/71X7QuA-JDL._SL1500_.jpg", 
    link: "https://www.amazon.es/American-Crew-Fiber-Cera-Fibrosa/dp/B000FZXGDS/ref=asc_df_B000FZXGDS?mcid=8efd0551f15d396ebb7d5e17c19c20dc&tag=googshopes-21&linkCode=df0&hvadid=699698651901&hvpos=&hvnetw=g&hvrand=7591777385585440045&hvpone=&hvptwo=&hvqmt=&hvdev=c&hvdvcmdl=&hvlocint=&hvlocphy=1005509&hvtargid=pla-434017948683&hvocijid=7591777385585440045-B000FZXGDS-&hvexpln=0&th=1" },

    { title: "Champú Alpecin Cafeína C1", price: "", 
    image: "https://m.media-amazon.com/images/I/913iZXbc4-L._AC_SL1500_.jpg", 
    link: "https://www.amazon.es/Alpecin-Champ%C3%BA-Cafe%C3%ADna-250-ml/dp/B0027SU56W?source=ps-sl-shoppingads-lpcontext&ref_=fplfs&smid=AO3EYUIRG6C64&th=1" },

    { title: "Aceite para Barba Proraso", price: "", 
    image: "https://m.media-amazon.com/images/I/61Tls-YbegL._AC_SL1220_.jpg", 
    link: "https://www.amazon.es/Proraso-Proteger-Especias-Aromatic-Mililitro/dp/B00PKA9NWQ/ref=asc_df_B00PKA9NWQ?mcid=0e7fc9a085a43bb9920f3fb4661c33bd&tag=googshopes-21&linkCode=df0&hvadid=699856549340&hvpos=&hvnetw=g&hvrand=16634994968659924280&hvpone=&hvptwo=&hvqmt=&hvdev=c&hvdvcmdl=&hvlocint=&hvlocphy=1005509&hvtargid=pla-377711548767&hvocijid=16634994968659924280-B00PKA9NWQ-&hvexpln=0&th=1" },
    
    { title: "Laca Nelly Profesional 600ml", price: "", 
    image: "https://m.media-amazon.com/images/I/411h7oammsL._AC_.jpg", 
    link: "https://www.amazon.es/NELLY-Fijaci%C3%B3n-Fuerte-Spray-Cabello/dp/B0GFFTPYX6/ref=asc_df_B0GFFTPYX6?mcid=38c80bdbf38c3b5ab019dd941883e324&tag=googshopes-21&linkCode=df0&hvadid=792424523443&hvpos=&hvnetw=g&hvrand=14200856036726506361&hvpone=&hvptwo=&hvqmt=&hvdev=c&hvdvcmdl=&hvlocint=&hvlocphy=1005509&hvtargid=pla-2518986695647&psc=1&hvocijid=14200856036726506361-B0GFFTPYX6-&hvexpln=0" },

    { title: "Wahl Magic Clip Cordless", price: "", 
    image: "https://m.media-amazon.com/images/I/714UzYD6jwL._AC_SL1500_.jpg", 
    link: "https://www.amazon.es/Wahl-Magic-Clip-Cortapelos-120V-60HZ/dp/B01FS6H5TO/ref=sr_1_2?adgrpid=68810607024&dib=eyJ2IjoiMSJ9.7QOTJevN7gjgZBV1SWW1eCxGudkZ0Rxc9FcsBcFNWWm5JIIbclixqjLum3up2IIpRAq8BUpI526PIheRJXAPslhlZX2Q5K5VBl91sL9ir8GI2Krr8pndaW7D56DisT_BsdWOawXklCMGAdhetsK5MU0cGQN25QlIL8ciwAqQbk5-SJeIjgm1lOz7m20xkZc5477dUVv_Ge6rPOilZqNSU8zJuknqbHgpwZNZHj7bOAdPuM7BbMDPMYVCnfjbatdzeWYOPx3YpKcKtLL5tJL06vi8d7FVWNJmNbb9XX7k0DU.hB69sHEATDzizY5ujHD0M3f-pDH-qRd7QGsZfWcH3TE&dib_tag=se&hvadid=712314289346&hvdev=c&hvexpln=0&hvlocphy=1005509&hvnetw=g&hvocijid=13735820321217136222--&hvqmt=b&hvrand=13735820321217136222&hvtargid=kwd-301462828313&hydadcr=27414_2406643&keywords=maquina+wahl+magic+clip&mcid=0325e47ee4b432be8adc3795bd0df706&qid=1777366761&sr=8-2&ufe=app_do%3Aamzn1.fos.4c3f56c3-e485-4a35-9abc-6532b61c3b62" },

    { title: "Tijeras Jaguar Pre Style", price: "", 
    image: "https://m.media-amazon.com/images/I/51XZ9aOKEfL._AC_SL1500_.jpg", 
    link: "https://www.amazon.es/Jaguar-Style-Relax-Tijera-pelo/dp/B003USS5QA/ref=asc_df_B003USS5QA?mcid=45df6c21338038e7b14c9435ca254844&tag=googshopes-21&linkCode=df0&hvadid=699760474782&hvpos=&hvnetw=g&hvrand=1320174351043901668&hvpone=&hvptwo=&hvqmt=&hvdev=c&hvdvcmdl=&hvlocint=&hvlocphy=1005509&hvtargid=pla-433251484960&hvocijid=1320174351043901668-B003USS5QA-&hvexpln=0&th=1" },

    { title: "L'Oréal Professionnel Serie Expert", price: "", 
    image: "https://m.media-amazon.com/images/I/514J1cpR6PL._SL1500_.jpg", 
    link: "https://www.amazon.es/LOREAL-Expert-Absolut-Repair-Conditioner/dp/B097BGDJV2/ref=asc_df_B097BGDJV2?mcid=2a05f2d070e13181a5b1d40e91f1c4ff&tag=googshopes-21&linkCode=df0&hvadid=699873900149&hvpos=&hvnetw=g&hvrand=5522982238215693029&hvpone=&hvptwo=&hvqmt=&hvdev=c&hvdvcmdl=&hvlocint=&hvlocphy=1005509&hvtargid=pla-1391870253481&psc=1&hvocijid=5522982238215693029-B097BGDJV2-&hvexpln=0" },

    { title: "Gomina Schwarzkopf Got2b Glued", price: "", 
    image: "https://m.media-amazon.com/images/I/51m3zVc78AL._AC_SL1000_.jpg", 
    link: "https://www.amazon.es/Got2B-Gel-Glued-SGlue-150/dp/B013XBLLFU/ref=asc_df_B013XBLLFU?mcid=0acd42bd69a636b6b12b61fa735dfb93&tag=googshopes-21&linkCode=df0&hvadid=699703513611&hvpos=&hvnetw=g&hvrand=10618064095923182307&hvpone=&hvptwo=&hvqmt=&hvdev=c&hvdvcmdl=&hvlocint=&hvlocphy=1005509&hvtargid=pla-627406628557&psc=1&hvocijid=10618064095923182307-B013XBLLFU-&hvexpln=0" },

    { title: "Andis Slimline Pro Li T-Blade", price: "", 
    image: "https://m.media-amazon.com/images/I/51Dc3ivbzZL._AC_SL1500_.jpg", 
    link: "https://www.amazon.es/Andis-SlimLine-Cordless-Rechargeable-T-Blade/dp/B0BYQJJ72H/ref=asc_df_B0BYQJJ72H?mcid=452d96d4900131ca95d0bce158c796f6&tag=googshopes-21&linkCode=df0&hvadid=705990800047&hvpos=&hvnetw=g&hvrand=240225938886912264&hvpone=&hvptwo=&hvqmt=&hvdev=c&hvdvcmdl=&hvlocint=&hvlocphy=1005509&hvtargid=pla-2328390488591&psc=1&hvocijid=240225938886912264-B0BYQJJ72H-&hvexpln=0" },

    { title: "Champú Revlon UniqOne", price: "", 
    image: "https://m.media-amazon.com/images/I/41ajAwZlHjL._AC_SL1065_.jpg", 
    link: "https://www.amazon.es/Revlon-Professional-Beneficios-Fortalece-Encrespamiento/dp/B09D84Y44J/ref=asc_df_B09D84Y44J?mcid=24d0593734f837858ebb31c6ac5fcde0&tag=googshopes-21&linkCode=df0&hvadid=699804787138&hvpos=&hvnetw=g&hvrand=7260072843461805151&hvpone=&hvptwo=&hvqmt=&hvdev=c&hvdvcmdl=&hvlocint=&hvlocphy=1005509&hvtargid=pla-1454547344547&hvocijid=7260072843461805151-B09D84Y44J-&hvexpln=0&th=1" },

    { title: "Bálsamo Barba Honest Amish", price: "", 
    image: "https://m.media-amazon.com/images/I/71w+Qqgb67L._AC_SL1500_.jpg", 
    link: "https://www.amazon.es/Honest-Amish-Beard-Balm-Conditioner/dp/B009NNFB0O/ref=asc_df_B009NNFB0O?mcid=6ec733c2c7cb3986b67ef7e788e95d0a&tag=googshopes-21&linkCode=df0&hvadid=699751553163&hvpos=&hvnetw=g&hvrand=9746094668851385649&hvpone=&hvptwo=&hvqmt=&hvdev=c&hvdvcmdl=&hvlocint=&hvlocphy=1005509&hvtargid=pla-378068502382&psc=1&hvocijid=9746094668851385649-B009NNFB0O-&hvexpln=0" },

    { title: "Secador Parlux Alyon Pro", price: "", 
    image: "https://m.media-amazon.com/images/I/614B75-PZ1L._AC_SL1500_.jpg", 
    link: "https://www.amazon.es/Parlux-Alyon-Secador-pelo-unidad/dp/B07C92KMSH/ref=asc_df_B07C92KMSH?mcid=d984d29f5a2a330aa520470b9de0937d&tag=googshopes-21&linkCode=df0&hvadid=699741119002&hvpos=&hvnetw=g&hvrand=300951821027901363&hvpone=&hvptwo=&hvqmt=&hvdev=c&hvdvcmdl=&hvlocint=&hvlocphy=1005509&hvtargid=pla-437863195337&hvocijid=300951821027901363-B07C92KMSH-&hvexpln=0&th=1" },

    { title: "Peine Carbono Antiestático", price: "", 
    image: "https://m.media-amazon.com/images/I/81zdziZOhkL._AC_SL1500_.jpg", 
    link: "https://www.amazon.es/K-Pro-Peine-Carbono-Antiest%C3%A1tico-Unisex/dp/B01HMLD560/ref=asc_df_B01HMLD560?mcid=dd5fd7f68e7b3e60a30a49a27cc8ffb9&tag=googshopes-21&linkCode=df0&hvadid=699826778066&hvpos=&hvnetw=g&hvrand=3606112013998876316&hvpone=&hvptwo=&hvqmt=&hvdev=c&hvdvcmdl=&hvlocint=&hvlocphy=1005509&hvtargid=pla-442208436398&hvocijid=3606112013998876316-B01HMLD560-&hvexpln=0&th=1" },

    { title: "Protector Térmico GHD Bodyguard", price: "", 
    image: "https://m.media-amazon.com/images/I/51sJMeXviaL._AC_SL1500_.jpg", 
    link: "https://www.amazon.es/ghd-Bodyguard-Protector-Invisible-Saludable/dp/B017NHI25M/ref=asc_df_B017NHI25M?mcid=2583cac7d8e735b6981f534c3351fa21&tag=googshopes-21&linkCode=df0&hvadid=802361449187&hvpos=&hvnetw=g&hvrand=8042311713532167941&hvpone=&hvptwo=&hvqmt=&hvdev=c&hvdvcmdl=&hvlocint=&hvlocphy=1005509&hvtargid=pla-2475481218673&hvocijid=8042311713532167941-B017NHI25M-&hvexpln=0&hvsb=player2&gad_source=1&gad_campaignid=23695104164&gbraid=0AAAAAD0FXH3qDH8HE1YH6YrTfs4pXhWMT&gclid=CjwKCAjwtcHPBhADEiwAWo3sJiHFOMR4A14AGDr916LLCAwon8bSuDnxmDGhCgrgGnChW5OOanizcRoCco0QAvD_BwE&th=1" },

    { title: "Aftershave Floïd Mentolado", price: "", 
    image: "https://m.media-amazon.com/images/I/61AnJEpX8AL._AC_SL1500_.jpg", 
    link: "amazon.es/After-Shave-Genuine-400-ml/dp/B09PCBTJGD/ref=asc_df_B09PCBTJGD?mcid=ad63494cabbd35c6a2620bbedfe8b4d2&tag=googshopes-21&linkCode=df0&hvadid=699776749576&hvpos=&hvnetw=g&hvrand=11623936670072140485&hvpone=&hvptwo=&hvqmt=&hvdev=c&hvdvcmdl=&hvlocint=&hvlocphy=1005509&hvtargid=pla-1608032299183&psc=1&hvocijid=11623936670072140485-B09PCBTJGD-&hvexpln=0" },

    { title: "Polvos Volum. Slick Gorilla", price: "", 
    image: "https://m.media-amazon.com/images/I/617qUYsjR6L._AC_SL1360_.jpg", 
    link: "https://www.amazon.es/Slick-Gorilla-Styling-Powder-peinado/dp/B06XZNJWZL/ref=asc_df_B06XZNJWZL?mcid=124abbde91c33f458b2f8d17591fadd1&tag=googshopes-21&linkCode=df0&hvadid=699873900155&hvpos=&hvnetw=g&hvrand=1047624796225203246&hvpone=&hvptwo=&hvqmt=&hvdev=c&hvdvcmdl=&hvlocint=&hvlocphy=1005509&hvtargid=pla-348317349590&psc=1&hvocijid=1047624796225203246-B06XZNJWZL-&hvexpln=0" },

    { title: "Spray de Sal Marina Osis+", price: "", 
    image: "https://m.media-amazon.com/images/I/51LbCnrhDOL._AC_SL1500_.jpg", 
    link: "https://www.amazon.es/Schwarzkopf-Osis-Air-Whip-200/dp/B0BZTBDMBN/ref=asc_df_B0BZTBDMBN?mcid=56ffc586dcf03770a044573edd411056&tag=googshopes-21&linkCode=df0&hvadid=699755845812&hvpos=&hvnetw=g&hvrand=1163809700060084277&hvpone=&hvptwo=&hvqmt=&hvdev=c&hvdvcmdl=&hvlocint=&hvlocphy=1005509&hvtargid=pla-2194031830209&hvocijid=1163809700060084277-B0BZTBDMBN-&hvexpln=0&th=1" },

    { title: "Navaja de Afeitar Parker 31R", price: "", 
    image: "https://m.media-amazon.com/images/I/61JbmjT6+TL._AC_SL1000_.jpg", 
    link: "https://www.amazon.es/Navaja-Afeitar-Superior-Platinum-cuchillas/dp/B01L73T0RM/ref=asc_df_B01L73T0RM?mcid=d0c6cb1a792738ad8876f704d7964889&tag=googshopes-21&linkCode=df0&hvadid=699736508077&hvpos=&hvnetw=g&hvrand=2817501172343293886&hvpone=&hvptwo=&hvqmt=&hvdev=c&hvdvcmdl=&hvlocint=&hvlocphy=1005509&hvtargid=pla-433807872883&psc=1&hvocijid=2817501172343293886-B01L73T0RM-&hvexpln=0" },

    { title: "Brocha de Afeitar Omega", price: "", 
    image: "https://m.media-amazon.com/images/I/61xmaSfvgcL._AC_SL1500_.jpg", 
    link: "https://www.amazon.es/Omega-10098-Bristle-Shaving-Brush/dp/B002V40IS2/ref=asc_df_B002V40IS2?mcid=7c7c2463ab833a679d7d100a8d54f7d8&tag=googshopes-21&linkCode=df0&hvadid=699783912871&hvpos=&hvnetw=g&hvrand=4333564054712491789&hvpone=&hvptwo=&hvqmt=&hvdev=c&hvdvcmdl=&hvlocint=&hvlocphy=1005509&hvtargid=pla-406644994255&psc=1&hvocijid=4333564054712491789-B002V40IS2-&hvexpln=0" },

    { title: "Talco Clubman Pinaud", price: "", 
    image: "https://m.media-amazon.com/images/I/51PWz1KkOyL._AC_SL1000_.jpg", 
    link: "https://www.amazon.es/Pinaud-CLUBMAN-talco-Color-blanco/dp/B00006BN44/ref=asc_df_B00006BN44?mcid=6e5623b33eb937c3b6db5b477978dab9&tag=googshopes-21&linkCode=df0&hvadid=699819906239&hvpos=&hvnetw=g&hvrand=17011981267573991273&hvpone=&hvptwo=&hvqmt=&hvdev=c&hvdvcmdl=&hvlocint=&hvlocphy=1005509&hvtargid=pla-332845344415&psc=1&hvocijid=17011981267573991273-B00006BN44-&hvexpln=0" },

    { title: "GHD Gold Styler - Plancha", price: "", 
    image: "https://m.media-amazon.com/images/I/71leadKIJ6L._SL1500_.jpg", 
    link: "amazon.es/ghd-gold-profesional-temperatura-tecnología/dp/B0CCYPDLCQ/ref=asc_df_B0CCYPDLCQ?mcid=db8b3145b4323b54a97379582b773f40&tag=googshopes-21&linkCode=df0&hvadid=802361449187&hvpos=&hvnetw=g&hvrand=14791684199497857482&hvpone=&hvptwo=&hvqmt=&hvdev=c&hvdvcmdl=&hvlocint=&hvlocphy=1005509&hvtargid=pla-2475481218673&psc=1&hvocijid=14791684199497857482-B0CCYPDLCQ-&hvexpln=0&hvsb=player2&gad_source=1&gad_campaignid=23695104164&gbraid=0AAAAAD0FXH3qDH8HE1YH6YrTfs4pXhWMT&gclid=CjwKCAjwtcHPBhADEiwAWo3sJs0Ei42WsuYEb2-WRSOEnWmG1zxu8Sy28ZlH4QTn-ZiDksl26bNrTxoCgj0QAvD_BwE" },

    { title: "Serum Kerastase Nutritive", price: "", 
    image: "https://m.media-amazon.com/images/I/61TNX4m8WyL._SL1500_.jpg", 
    link: "https://www.amazon.es/K%C3%A9rastase-Nutritive-Magic-Night-Tama%C3%B1o/dp/B0F2QZQWDN/ref=asc_df_B0F2QZQWDN?mcid=6881f736207f343bb5a8617910d98ecc&tag=googshopes-21&linkCode=df0&hvadid=784713143901&hvpos=&hvnetw=g&hvrand=17441332724859865514&hvpone=&hvptwo=&hvqmt=&hvdev=c&hvdvcmdl=&hvlocint=&hvlocphy=1005509&hvtargid=pla-2421698457508&psc=1&hvocijid=17441332724859865514-B0F2QZQWDN-&hvexpln=0" },

    { title: "Pomada Uppercut Deluxe", price: "", 
    image: "https://m.media-amazon.com/images/I/71E8nU3H8bL._AC_SL1200_.jpg", 
    link: "https://www.amazon.es/Uppercut-Profesional-Cl%C3%A1sicos-Atemporales-Fijaci%C3%B3n/dp/B005IC3C1O/ref=asc_df_B005IC3C1O?mcid=a65e711cea2432a69e1e1d393030822d&tag=googshopes-21&linkCode=df0&hvadid=699760474782&hvpos=&hvnetw=g&hvrand=14198431816986510534&hvpone=&hvptwo=&hvqmt=&hvdev=c&hvdvcmdl=&hvlocint=&hvlocphy=1005509&hvtargid=pla-421966810968&psc=1&hvocijid=14198431816986510534-B005IC3C1O-&hvexpln=0" },

    { title: "Gel de Afeitado Elegance", price: "", 
    image: "https://m.media-amazon.com/images/I/51AYVYwho-L._AC_SL1024_.jpg", 
    link: "https://www.amazon.es/Transparente-Afeitado-Espumoso-Contorno-Cualquier/dp/B09XVBN1SX/ref=asc_df_B09XVBN1SX?mcid=64e28cf71cdb3ab6a1a60c54ad81d031&tag=googshopes-21&linkCode=df0&hvadid=704489726074&hvpos=&hvnetw=g&hvrand=1874245783444270713&hvpone=&hvptwo=&hvqmt=&hvdev=c&hvdvcmdl=&hvlocint=&hvlocphy=1005509&hvtargid=pla-2091649159857&psc=1&hvocijid=1874245783444270713-B09XVBN1SX-&hvexpln=0" }

];

let currentPage = 1;
const itemsPerPage = 8; 

function renderProducts() {
    const grid = document.getElementById('productsGrid');
    const query = document.getElementById('searchInput').value.toLowerCase();
    
    const filtered = products.filter(p => p.title.toLowerCase().includes(query));
    
    const totalPages = Math.ceil(filtered.length / itemsPerPage);
    const start = (currentPage - 1) * itemsPerPage;
    const paginatedItems = filtered.slice(start, start + itemsPerPage);

    grid.innerHTML = paginatedItems.map(p => `
        <div class="col">
            <div class="card product-card p-3">
                <div class="img-container">
                    <img src="${p.image}" alt="${p.title}" onerror="this.src='https://via.placeholder.com/200x200?text=Imagen+No+Disponible'">
                </div>
                <div class="product-title text-white text-center">${p.title}</div>
                <div class="price-tag text-center">${p.price}</div>
                <div class="mt-auto">
                    <a href="${p.link}" target="_blank" class="btn btn-warning w-100 fw-bold text-dark">
                        <i class="fas fa-external-link-alt me-1"></i> VER EN TIENDA
                    </a>
                </div>
            </div>
        </div>
    `).join('');

    renderPagination(totalPages);
}

function renderPagination(totalPages) {
    const nav = document.getElementById('pagination');
    let html = '';
    for (let i = 1; i <= totalPages; i++) {
        html += `
            <li class="page-item ${i === currentPage ? 'active' : ''}">
                <a class="page-link" href="#" onclick="setPage(${i})">${i}</a>
            </li>
        `;
    }
    nav.innerHTML = html;
}

function setPage(i) {
    currentPage = i;
    renderProducts();
    window.scrollTo(0, 0);
}

function resetAndRender() {
    currentPage = 1;
    renderProducts();
}

renderProducts();
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>