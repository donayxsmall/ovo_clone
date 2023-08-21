// ignore_for_file: camel_case_types, prefer_typing_uninitialized_variables

import 'package:carousel_slider/carousel_slider.dart';
import 'package:flutter/material.dart';
import 'package:flutter_svg/flutter_svg.dart';
import 'package:go_router/go_router.dart';
import 'package:ovo_clone/core.dart';

class HomeScreen extends StatefulWidget {
  const HomeScreen({Key? key}) : super(key: key);

  @override
  State<HomeScreen> createState() => _HomeScreenState();
}

class _HomeScreenState extends State<HomeScreen> {
  List menus = [
    {
      "icon": "assets/image/menu/pln.png",
      "label": "PLN",
      "bgColor": const Color(0xffFEAD46).withOpacity(0.2),
      "onTap": () {},
    },
    {
      "icon": "assets/image/menu/pulsa.png",
      "label": "Pulsa",
      "bgColor": const Color(0xff0071BC).withOpacity(0.2),
      "onTap": () {},
    },
    {
      "icon": "assets/image/menu/paket_data.png",
      "label": "Paket Data",
      "bgColor": const Color(0xff00C568).withOpacity(0.2),
      "onTap": () {},
    },
    {
      "icon": "assets/image/menu/pasca_bayar.png",
      "label": "Pasca Bayar",
      "bgColor": const Color(0xff00B0B7).withOpacity(0.2),
      "onTap": () {},
    },
    {
      "icon": "assets/image/menu/bpjs.png",
      "label": "BPJS",
      "bgColor": const Color(0xff00C568).withOpacity(0.2),
      "onTap": () {},
    },
    {
      "icon": "assets/image/menu/layanan_tv.png",
      "label": "Internet & TV Kabel",
      "bgColor": const Color(0xffF4581F).withOpacity(0.2),
      "onTap": () {},
    },
    {
      "icon": "assets/image/menu/iuran_keuangan.png",
      "label": "Iuran Keuangan",
      "bgColor": const Color(0xff19A7CE).withOpacity(0.2),
      "onTap": () {},
    },
    {
      "icon": "assets/image/menu/lainnya.png",
      "label": "Lainnya",
      "bgColor": const Color(0xff8E50DD).withOpacity(0.2),
      "onTap": () {},
    },
  ];

  int currentIndex = 0;
  final CarouselController carouselController = CarouselController();

  @override
  Widget build(BuildContext context) {
    Size screenSize = MediaQuery.of(context).size;
    double screenWidth = screenSize.width;
    // double screenHeight = screenSize.height;

    return Scaffold(
      body: Stack(
        children: [
          Container(
            height: MediaQuery.of(context).size.height * 0.35,
            decoration: const BoxDecoration(
              image: DecorationImage(
                  image: AssetImage('assets/image/head_background_home.png'),
                  fit: BoxFit.fill),
            ),
          ),
          Container(
            margin: const EdgeInsets.symmetric(horizontal: 18, vertical: 15),
            child: Column(
              crossAxisAlignment: CrossAxisAlignment.start,
              children: [
                Row(
                  mainAxisAlignment: MainAxisAlignment.spaceBetween,
                  children: [
                    SvgPicture.asset('assets/image/logo_ovo.svg',
                        width: 17, height: 17),
                    const Icon(
                      Icons.notifications,
                      color: Colors.white,
                    )
                  ],
                ),
                const SizedBox(
                  height: 15.0,
                ),
                Column(
                  crossAxisAlignment: CrossAxisAlignment.start,
                  children: [
                    const Text(
                      "OVO Cash",
                      style: TextStyle(
                        fontSize: 12.0,
                        fontWeight: FontWeight.bold,
                        color: Colors.white,
                      ),
                    ),
                    const SizedBox(
                      height: 8.0,
                    ),
                    const Row(
                      crossAxisAlignment: CrossAxisAlignment.start,
                      children: [
                        Text(
                          "Rp",
                          style: TextStyle(
                            fontSize: 12.0,
                            fontWeight: FontWeight.bold,
                            color: Colors.white,
                          ),
                        ),
                        SizedBox(
                          width: 3.0,
                        ),
                        Text(
                          "4.980.000",
                          style: TextStyle(
                            fontSize: 28.0,
                            fontWeight: FontWeight.bold,
                            color: Colors.white,
                          ),
                        ),
                      ],
                    ),
                    const SizedBox(
                      height: 8.0,
                    ),
                    RichText(
                      text: const TextSpan(children: [
                        TextSpan(
                            text: 'OVO Points',
                            style: TextStyle(
                              color: Color(0xffD9D9D9),
                              fontSize: 12.0,
                            )),
                        TextSpan(
                          text: '  20.574',
                          style: TextStyle(
                            color: Color(0xffFEAD46),
                            fontSize: 12.0,
                          ),
                        )
                      ]),
                    ),
                    const SizedBox(
                      height: 15.0,
                    ),
                    Card(
                      shape: ContinuousRectangleBorder(
                        borderRadius: BorderRadius.circular(20),
                      ),
                      child: Container(
                        padding: const EdgeInsets.all(10.0),
                        child: Row(
                          mainAxisAlignment: MainAxisAlignment.spaceEvenly,
                          children: [
                            buildItem(
                              image: Image.asset('assets/image/topup.png'),
                              label: 'Top Up',
                              onTap: () {},
                            ),
                            buildItem(
                              image: Image.asset('assets/image/transfer.png'),
                              label: 'Transfer',
                              onTap: () {
                                context.goNamed('secure-code');
                              },
                            ),
                            buildItem(
                              image: Image.asset('assets/image/history.png'),
                              label: 'History',
                              onTap: () {},
                            ),
                          ],
                        ),
                      ),
                    ),
                    const SizedBox(
                      height: 20.0,
                    ),
                  ],
                ),
              ],
            ),
          ),
          Positioned(
            top: 250,
            bottom: 0,
            left: 0,
            right: 0,
            child: SingleChildScrollView(
              child: Column(
                children: [
                  Card(
                    child: Container(
                      padding: const EdgeInsets.all(10.0),
                      child: GridView.builder(
                        padding: EdgeInsets.zero,
                        gridDelegate:
                            const SliverGridDelegateWithFixedCrossAxisCount(
                          childAspectRatio: 1,
                          crossAxisCount: 4,
                          mainAxisSpacing: 20,
                          crossAxisSpacing: 6,
                        ),
                        itemCount: menus.length,
                        shrinkWrap: true,
                        physics: const ScrollPhysics(),
                        itemBuilder: (BuildContext context, int index) {
                          var item = menus[index];
                          return InkWell(
                            onTap: item["onTap"],
                            child: Column(
                              crossAxisAlignment: CrossAxisAlignment.center,
                              mainAxisAlignment: MainAxisAlignment.center,
                              children: [
                                CircleAvatar(
                                  backgroundColor: item["bgColor"],
                                  child: Image.asset(
                                    "${item['icon']}",
                                  ),
                                ),
                                const SizedBox(
                                  height: 4.0,
                                ),
                                Expanded(
                                  child: Text(
                                    "${item['label']}",
                                    textAlign: TextAlign.center,
                                    overflow: TextOverflow.clip,
                                    style: TextStyle(
                                      color: Colors.black,
                                      fontSize: screenWidth * 0.03,
                                    ),
                                  ),
                                ),
                              ],
                            ),
                          );
                        },
                      ),
                    ),
                  ),
                  const SizedBox(
                    height: 15.0,
                  ),
                  Card(
                    child: Container(
                      padding: const EdgeInsets.all(10.0),
                      margin: const EdgeInsets.symmetric(horizontal: 10),
                      child: Column(
                        children: [
                          Row(
                            mainAxisAlignment: MainAxisAlignment.spaceBetween,
                            children: [
                              const Text(
                                "Info dan Promo Spesial",
                                style: TextStyle(
                                  fontSize: 18.0,
                                  fontWeight: FontWeight.bold,
                                  color: Colors.black,
                                ),
                              ),
                              TextButton(
                                onPressed: () {},
                                child: const Text(
                                  "Lihat Semua",
                                  style: TextStyle(
                                    fontSize: 12.0,
                                    fontWeight: FontWeight.bold,
                                  ),
                                ),
                              )
                            ],
                          ),
                          const SizedBox(
                            height: 10.0,
                          ),
                          CarouselMenu(
                            items: [
                              {
                                "image":
                                    "https://images.unsplash.com/photo-1555939594-58d7cb561ad1?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=687&q=80",
                                "onTap": () {},
                              },
                              {
                                "image":
                                    "https://images.unsplash.com/photo-1540189549336-e6e99c3679fe?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=687&q=80",
                                "onTap": () {},
                              },
                              {
                                "image":
                                    "https://images.unsplash.com/photo-1565299624946-b28f40a0ae38?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=781&q=80",
                                "onTap": () {},
                              },
                              {
                                "image":
                                    "https://images.unsplash.com/photo-1565958011703-44f9829ba187?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=765&q=80",
                                "onTap": () {},
                              },
                              {
                                "image":
                                    "https://images.unsplash.com/photo-1482049016688-2d3e1b311543?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=710&q=80",
                                "onTap": () {},
                              }
                            ],
                          ),
                        ],
                      ),
                    ),
                  ),
                  const SizedBox(
                    height: 20.0,
                  ),
                  const Divider(),
                ],
              ),
            ),
          ),
        ],
      ),
    );
  }

  Widget buildItem({
    required Image image,
    required String label,
    required Function() onTap,
  }) {
    return InkWell(
      onTap: onTap,
      child: Column(
        children: [
          image,
          const SizedBox(
            height: 10.0,
          ),
          Text(
            label,
            style: const TextStyle(
              fontSize: 14.0,
            ),
          ),
        ],
      ),
    );
  }
}
