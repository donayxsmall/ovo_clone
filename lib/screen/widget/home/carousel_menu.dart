// ignore_for_file: camel_case_types, prefer_typing_uninitialized_variables

import 'package:cached_network_image/cached_network_image.dart';
import 'package:carousel_slider/carousel_slider.dart';
import 'package:flutter/material.dart';

import 'package:ovo_clone/core.dart';

class CarouselMenu extends StatefulWidget {
  const CarouselMenu({
    Key? key,
    required this.items,
  }) : super(key: key);

  final List items;

  @override
  State<CarouselMenu> createState() => _CarouselMenuState();
}

class _CarouselMenuState extends State<CarouselMenu> {
  int currentIndex = 0;
  final CarouselController carouselController = CarouselController();

  @override
  Widget build(BuildContext context) {
    return Builder(builder: (context) {
      return Column(
        children: [
          CarouselSlider(
            carouselController: carouselController,
            options: CarouselOptions(
              height: 160.0,
              autoPlay: true,
              enlargeCenterPage: false,
              viewportFraction: 0.8,
              onPageChanged: (index, reason) {
                currentIndex = index;
                setState(() {});
              },
            ),
            items: widget.items.map((imageUrl) {
              return Builder(
                builder: (BuildContext context) {
                  return InkWell(
                    onTap: imageUrl['onTap'],
                    child: CachedNetworkImage(
                      imageUrl: imageUrl['image'],
                      imageBuilder: (context, imageProvider) => Container(
                        width: MediaQuery.of(context).size.width,
                        margin: const EdgeInsets.symmetric(horizontal: 5.0),
                        decoration: BoxDecoration(
                          color: Colors.amber,
                          borderRadius: const BorderRadius.all(
                            Radius.circular(6.0),
                          ),
                          image: DecorationImage(
                            image: imageProvider,
                            fit: BoxFit.cover,
                          ),
                        ),
                      ),
                      placeholder: (context, url) => Container(
                        alignment: Alignment.center,
                        child: const CircularProgressIndicator(),
                      ),
                      errorWidget: (context, url, error) =>
                          const Icon(Icons.error),
                    ),
                  );
                },
              );
            }).toList(),
          ),
          Row(
            mainAxisAlignment: MainAxisAlignment.center,
            children: widget.items.asMap().entries.map((entry) {
              bool isSelected = currentIndex == entry.key;
              return GestureDetector(
                onTap: () => carouselController.animateToPage(entry.key),
                child: Container(
                  width: isSelected ? 40 : 6.0,
                  height: 6.0,
                  margin: const EdgeInsets.only(
                    right: 6.0,
                    top: 12.0,
                  ),
                  decoration: BoxDecoration(
                    color: isSelected ? primaryColor : const Color(0xff3c3e40),
                    borderRadius: const BorderRadius.all(
                      Radius.circular(12.0),
                    ),
                  ),
                ),
              );
            }).toList(),
          ),
        ],
      );
    });
  }
}
