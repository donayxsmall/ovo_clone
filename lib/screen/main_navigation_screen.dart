// ignore_for_file: camel_case_types, prefer_typing_uninitialized_variables

import 'package:flutter/material.dart';
import 'package:ovo_clone/core.dart';

class MainNavigationScreen extends StatefulWidget {
  const MainNavigationScreen({Key? key}) : super(key: key);

  @override
  State<MainNavigationScreen> createState() => _MainNavigationScreenState();
}

class _MainNavigationScreenState extends State<MainNavigationScreen> {
  int selectedIndex = 0;
  updateIndex(int newIndex) {
    selectedIndex = newIndex;
    setState(() {});
  }

  final Color _selectedItemColor = primaryColor;
  final Color _unselectedItemColor = const Color(0xff909090);

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      body: SafeArea(
        child: IndexedStack(
          index: selectedIndex,
          children: const [
            HomeScreen(),
            FinanceScreen(),
            InboxScreen(),
            ProfileScreen(),
          ],
        ),
      ),
      floatingActionButton: Container(
        margin: const EdgeInsets.only(
          top: 20.0,
        ),
        child: Stack(
          children: [
            Container(
              width: 60,
              height: 60,
              decoration: const BoxDecoration(
                shape: BoxShape.circle,
                color: Colors.white,
              ),
            ),
            Column(
              mainAxisSize: MainAxisSize.min,
              children: [
                Container(
                  margin: const EdgeInsets.only(
                    top: 5.0,
                    left: 5,
                  ),
                  width: 50,
                  height: 50,
                  decoration: BoxDecoration(
                    shape: BoxShape.circle,
                    gradient: LinearGradient(
                      begin: Alignment.topCenter,
                      end: Alignment.bottomRight,
                      // transform: GradientRotation(90),
                      colors: [
                        const Color(0xff40128B),
                        const Color(0xffDD58D6).withOpacity(0.5),
                      ],
                    ),
                  ),
                  child: Image.asset('assets/image/logo_qris.png'),
                ),
                const SizedBox(
                    height: 2.0), // Adjust the space between FAB and label
                Container(
                  margin: const EdgeInsets.only(
                    left: 6.0,
                  ),
                  child: Text(
                    'Pay',
                    // Label text
                    style: TextStyle(
                        fontSize: 13.0,
                        color:
                            _unselectedItemColor), // Customize the label font size
                  ),
                ),
              ],
            ),
          ],
        ),
      ),
      floatingActionButtonLocation: FloatingActionButtonLocation.centerDocked,
      bottomNavigationBar: BottomAppBar(
        child: SizedBox(
          height: kBottomNavigationBarHeight,
          child: Row(
            mainAxisAlignment: MainAxisAlignment.spaceAround,
            children: [
              buildNavItem(Icons.home, 'Home', 0),
              buildNavItemCustom(
                icon: SizedBox(
                  width: 25,
                  height: 25,
                  child: CircleAvatar(
                    backgroundColor: selectedIndex == 1
                        ? _selectedItemColor
                        : _unselectedItemColor,
                    child: const Text(
                      'Rp',
                      style: TextStyle(
                        color: Colors.white,
                        fontSize: 12.0,
                      ),
                    ),
                  ),
                ),
                label: 'Finance',
                index: 1,
              ),
              const SizedBox(
                width: 20.0,
              ),
              Container(
                margin: const EdgeInsets.only(
                  right: 20.0,
                ),
                child: buildNavItem(Icons.notifications, 'Inbox', 2),
              ),
              buildNavItemWithImage(
                icon: Container(
                  margin: const EdgeInsets.only(
                    bottom: 3.0,
                  ),
                  child: Image.asset(
                    'assets/image/icon_user.png',
                    color: selectedIndex == 3
                        ? _selectedItemColor
                        : _unselectedItemColor,
                  ),
                ),
                label: 'Profile',
                index: 3,
              ),
            ],
          ),
        ),
      ),
    );
  }

  Widget buildNavItem(IconData icon, String label, int index) {
    return InkWell(
      onTap: () => updateIndex(index),
      child: Column(
        mainAxisSize: MainAxisSize.min,
        children: [
          Icon(
            icon,
            color: selectedIndex == index
                ? _selectedItemColor
                : _unselectedItemColor,
          ),
          Text(
            label,
            style: TextStyle(
              color: selectedIndex == index
                  ? _selectedItemColor
                  : _unselectedItemColor,
              fontSize: selectedIndex == index ? 13.0 : 10,
              fontWeight: selectedIndex == index ? FontWeight.bold : null,
            ),
          ),
        ],
      ),
    );
  }

  Widget buildNavItemWithImage(
      {required Widget icon, required String label, required int index}) {
    return InkWell(
      onTap: () => updateIndex(index),
      child: Column(
        mainAxisSize: MainAxisSize.min,
        children: [
          icon,
          Text(
            label,
            style: TextStyle(
              color: selectedIndex == index
                  ? _selectedItemColor
                  : _unselectedItemColor,
              fontSize: selectedIndex == index ? 13.0 : 10,
              fontWeight: selectedIndex == index ? FontWeight.bold : null,
            ),
          ),
        ],
      ),
    );
  }

  Widget buildNavItemCustom(
      {required Widget icon, required String label, required int index}) {
    return InkWell(
      onTap: () => updateIndex(index),
      child: Column(
        mainAxisSize: MainAxisSize.min,
        children: [
          icon,
          Text(
            label,
            style: TextStyle(
              color: selectedIndex == index
                  ? _selectedItemColor
                  : _unselectedItemColor,
              fontSize: selectedIndex == index ? 13.0 : 10,
              fontWeight: selectedIndex == index ? FontWeight.bold : null,
            ),
          ),
        ],
      ),
    );
  }
}
