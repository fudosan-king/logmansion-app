import 'package:flutter/cupertino.dart';
import 'package:flutter/material.dart';
import 'package:flutter/widgets.dart';
import 'package:flutter_bloc/flutter_bloc.dart';
import 'package:flutter_screenutil/flutter_screenutil.dart';

import '../../blocs/authentication/authentication_bloc.dart';
import '../../blocs/authentication/authentication_event.dart';
import '../../models/schedule.dart';
import '../../widgets/colors.dart';
import '../catalog/catalog_screen.dart';

class HomeScreen extends StatefulWidget {
  HomeScreen({super.key});

  @override
  _HomeScreenState createState() => _HomeScreenState();

  static Route<void> route() {
    return MaterialPageRoute<void>(builder: (_) => HomeScreen());
  }
}

class _HomeScreenState extends State<HomeScreen> {
  @override
  void initState() {
    super.initState();
  }

  @override
  Widget build(BuildContext context) {
    final userName = context.select((AuthenticationBloc bloc) => bloc.state.user.name);
    return SizedBox(
      width: 375.w,
      height: 812.h,
      child: Stack(
        children: [
          Positioned(
            left: 0,
            top: 0,
            right: 0,
            child: Container(
              width: 375.w,
              height: 310.h,
              decoration: const BoxDecoration(
                color: Color(0xffC8CDE8),
                image: DecorationImage(
                  image: AssetImage(
                    'assets/images/home-bg.png',
                  ),
                  fit: BoxFit.cover,
                ),
              ),
              padding: EdgeInsets.only(top: 110.h),
              child: Center(
                child: Container(
                  width: 222.w,
                  height: 58.h,
                  child: Column(
                      mainAxisSize: MainAxisSize.min,
                      mainAxisAlignment: MainAxisAlignment.start,
                      crossAxisAlignment: CrossAxisAlignment.center,
                      children: [
                        Container(
                          width: 222.w,
                          height: 30.h,
                          clipBehavior: Clip.antiAlias,
                          decoration: const BoxDecoration(),
                          child: Image.asset("assets/images/logo.png"),
                        ),
                        const SizedBox(height: 10),
                        const Text(
                          'OWNERS CLUB',
                          textAlign: TextAlign.center,
                          style: TextStyle(
                            color: Colors.white,
                            fontSize: 14,
                            fontFamily: 'Didact Gothic',
                            fontWeight: FontWeight.w400,
                            height: 0,
                            letterSpacing: 2,
                          ),
                        ),
                      ]),
                ),
              ),
            ),
          ),
          Positioned(
            left: 0,
            top: 270.h,
            child: Container(
              width: 375.w,
              height: 542.h,
              // color: const Color(0xFFF2F4FA),
              padding: const EdgeInsets.only(top: 30),
              decoration: const ShapeDecoration(
                color: AppColors.primaryColor,
                shape: RoundedRectangleBorder(
                  borderRadius: BorderRadius.only(
                    topLeft: Radius.circular(24),
                    topRight: Radius.circular(24),
                  ),
                ),
              ),
              child: Column(
                mainAxisSize: MainAxisSize.min,
                children: [
                  // Builder(
                  //   builder: (context) {
                  //     final userId = context.select(
                  //       (AuthenticationBloc bloc) => bloc.state.user.id,
                  //     );
                  //     return Text('UserID: $userId');
                  //   },
                  // ),
                  // ElevatedButton(
                  //   child: const Text('Logout'),
                  //   onPressed: () {
                  //     context
                  //         .read<AuthenticationBloc>()
                  //         .add(AuthenticationLogoutRequested());
                  //   },
                  // ),
                ],
              ),
            ),
          ),
          Positioned(
            left: 0,
            top: 250.h,
            child: Container(
              width: 375.w,
              height: 500.h,
              padding: const EdgeInsets.only(left: 20, right: 20),
              child: SingleChildScrollView(
                child: Column(
                  mainAxisSize: MainAxisSize.min,
                  children: [
                    const ScheduleWidget(),
                    Welcome(name: userName),
                    SizedBox(height: 18.h),
                    const Menu(),
                    SizedBox(height: 60.h),
                  ],
                ),
              ),
            ),
          ),
        ],
      ),
    );
  }
}

class ScheduleWidget extends StatefulWidget {
  const ScheduleWidget({super.key});

  @override
  State<ScheduleWidget> createState() => _ScheduleWidgetState();
}

class _ScheduleWidgetState extends State<ScheduleWidget> {
  bool showAll = false;

  @override
  Widget build(BuildContext context) {
    List<Schedule> schedules = [
      Schedule(
          id: "1",
          name: 'Meeting1',
          description: '9:00 AM',
          date: "25.4.2024",
          position: 1),
      Schedule(
          id: "2",
          name: 'Meeting2',
          description: '9:00 AM',
          date: "25.4.2024",
          position: 1),
      Schedule(
          id: "3",
          name: 'Meeting3',
          description: '9:00 AM',
          date: "25.4.2024",
          position: 1),
      Schedule(
          id: "4",
          name: 'Meeting4',
          description: '9:00 AM',
          date: "25.4.2024",
          position: 1),
      Schedule(
          id: "5",
          name: 'Meeting5',
          description: '9:00 AM',
          date: "25.4.2024",
          position: 1),
      Schedule(
          id: "6",
          name: 'Meeting6',
          description: '9:00 AM',
          date: "25.4.2024",
          position: 1),
    ];
    return Column(
      mainAxisSize: MainAxisSize.min,
      mainAxisAlignment: MainAxisAlignment.start,
      crossAxisAlignment: CrossAxisAlignment.center,
      children: [
        Container(
          width: 335.w,
          clipBehavior: Clip.antiAlias,
          decoration: const BoxDecoration(),
          child: Column(
            mainAxisSize: MainAxisSize.min,
            mainAxisAlignment: MainAxisAlignment.start,
            crossAxisAlignment: CrossAxisAlignment.start,
            children: [
              ListView.builder(
                  padding: const EdgeInsets.only(top: 0, bottom: 0),
                  shrinkWrap: true,
                  physics: const NeverScrollableScrollPhysics(),
                  itemCount: showAll ? schedules.length : 2,
                  itemBuilder: (BuildContext context, int index) {
                    return ScheduleItem(schedule: schedules[index]);
                  }),
              // const SizedBox(height: 6),
              Center(
                child: IconButton(
                  icon: Icon(
                    showAll
                        ? Icons.keyboard_arrow_up_outlined
                        : Icons.keyboard_arrow_down_outlined,
                    color: AppColors.buttonColor,
                  ),
                  onPressed: () {
                    setState(() {
                      showAll = !showAll;
                    });
                  },
                ),
              ),
            ],
          ),
        ),
      ],
    );
  }
}

class ScheduleItem extends StatelessWidget {
  const ScheduleItem({
    super.key,
    required this.schedule,
  });

  final Schedule schedule;

  @override
  Widget build(BuildContext context) {
    return Container(
      height: 47.h,
      padding: EdgeInsets.all(12.w),
      margin: EdgeInsets.only(bottom: 6.h),
      clipBehavior: Clip.antiAlias,
      decoration: ShapeDecoration(
        color: Colors.white,
        shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(6)),
      ),
      child: SizedBox(
        height: 17.h,
        child: Row(
          mainAxisSize: MainAxisSize.min,
          mainAxisAlignment: MainAxisAlignment.center,
          crossAxisAlignment: CrossAxisAlignment.center,
          children: [
            Container(
              width: 16.w,
              height: 16.w,
              clipBehavior: Clip.antiAlias,
              decoration: const BoxDecoration(),
              child:
                  Image.asset("assets/images/icon_atention.png", width: 16.w),
            ),
            SizedBox(width: 6.w),
            Expanded(
              child: Text(
                schedule.name,
                // textAlign: TextAlign.center,
                overflow: TextOverflow.visible,
                maxLines: 1,
                style: const TextStyle(
                  color: AppColors.primaryBlack,
                  fontSize: 14,
                  fontFamily: 'SF Pro Display',
                  fontWeight: FontWeight.w700,
                  height: 0.08,
                ),
              ),
            ),
            const SizedBox(width: 6),
            Row(
              mainAxisSize: MainAxisSize.min,
              mainAxisAlignment: MainAxisAlignment.end,
              crossAxisAlignment: CrossAxisAlignment.center,
              children: [
                Text(
                  schedule.date,
                  textAlign: TextAlign.right,
                  maxLines: 1,
                  style: const TextStyle(
                    color: AppColors.textGrey500,
                    fontSize: 14,
                    fontFamily: 'SF Pro Display',
                    fontWeight: FontWeight.w700,
                    // height: 0.08,
                  ),
                ),
              ],
            ),
            const SizedBox(width: 16),
            Container(
              width: 16.w,
              height: 16.w,
              clipBehavior: Clip.antiAlias,
              decoration: const BoxDecoration(),
              child: Icon(Icons.arrow_forward_ios_outlined,
                  size: 16.w, color: AppColors.textGrey500),
            ),
          ],
        ),
      ),
    );
  }
}

class Welcome extends StatelessWidget {
  const Welcome({super.key, required this.name});
  final String name;

  @override
  Widget build(BuildContext context) {
    return Column(
      children: [
        Container(
          width: 335.w,
          // height: 46.h,
          child: Row(
            mainAxisSize: MainAxisSize.min,
            mainAxisAlignment: MainAxisAlignment.spaceBetween,
            crossAxisAlignment: CrossAxisAlignment.center,
            children: [
              Expanded(
                child: Container(
                  child: Column(
                    mainAxisSize: MainAxisSize.min,
                    mainAxisAlignment: MainAxisAlignment.start,
                    crossAxisAlignment: CrossAxisAlignment.start,
                    children: [
                      SizedBox(
                        width: double.infinity,
                        child: Text.rich(
                          TextSpan(
                            children: [
                              TextSpan(
                                text: name,
                                style: TextStyle(
                                  color: Colors.white,
                                  fontSize: 14,
                                  fontFamily: 'SF Pro Display',
                                  fontWeight: FontWeight.w700,
                                  height: 0,
                                ),
                              ),
                              TextSpan(
                                text: '様、こんにちは',
                                style: TextStyle(
                                  color: Colors.white,
                                  fontSize: 14,
                                  fontFamily: 'SF Pro Display',
                                  fontWeight: FontWeight.w400,
                                  height: 0,
                                ),
                              ),
                            ],
                          ),
                        ),
                      ),
                      Text.rich(
                        TextSpan(
                          children: [
                            TextSpan(
                              text: 'サポートデスクより返信が ',
                              style: TextStyle(
                                color: Colors.white,
                                fontSize: 14,
                                fontFamily: 'SF Pro Display',
                                fontWeight: FontWeight.w400,
                                height: 0,
                              ),
                            ),
                            TextSpan(
                              text: '2',
                              style: TextStyle(
                                color: Color(0xFFEB5757),
                                fontSize: 24,
                                fontFamily: 'SF Pro Display',
                                fontWeight: FontWeight.w700,
                                height: 0,
                              ),
                            ),
                            TextSpan(
                              text: ' ',
                              style: TextStyle(
                                color: Colors.white,
                                fontSize: 24,
                                fontFamily: 'SF Pro Display',
                                fontWeight: FontWeight.w400,
                                height: 0,
                              ),
                            ),
                            TextSpan(
                              text: '件あります。',
                              style: TextStyle(
                                color: Colors.white,
                                fontSize: 14,
                                fontFamily: 'SF Pro Display',
                                fontWeight: FontWeight.w400,
                                height: 0,
                              ),
                            ),
                          ],
                        ),
                      ),
                    ],
                  ),
                ),
              ),
              const SizedBox(width: 12),
              Container(
                width: 40.w,
                height: 40.w,
                child: Image.asset("assets/images/contact.png"),
              ),
            ],
          ),
        ),
      ],
    );
  }
}

class Menu extends StatelessWidget {
  const Menu({super.key});

  @override
  Widget build(BuildContext context) {
    return SizedBox(
      width: 335.w,
      height: 210.h,
      child: Wrap(
        spacing: 10,
        runSpacing: 10,
        children: [
          MenuItem(
              title: 'マイページ',
              image: 'assets/images/menu-icon1.png',),
          MenuItem(title: 'お問合わせ', image: 'assets/images/menu-icon2.png'),
          MenuItem(title: '契約書類', image: 'assets/images/menu-icon3.png'),
          MenuItem(title: 'オーダー家具', image: 'assets/images/menu-icon4.png',
              onTap: () {
                Navigator.of(context).push<void>(
                  CatalogScreen.route(),
                );
              }),
          MenuItem(title: 'お役立ち情報', image: 'assets/images/menu-icon5.png'),
          MenuItem(title: 'よくある質問', image: 'assets/images/menu-icon6.png'),
        ],
      ),
    );
  }
}

class MenuItem extends StatelessWidget {
  MenuItem({
    super.key,
    required this.title,
    required this.image,
    this.onTap,
  });

  final String title;
  final String image;
  void Function()? onTap;

  @override
  Widget build(BuildContext context) {
    return InkWell(
      onTap: onTap,
      child: Container(
        width: 105.w,
        height: 100.w,
        // padding: const EdgeInsets.only(
        //   top: 15,
        //   left: 34,
        //   right: 34,
        //   bottom: 15,
        // ),
        clipBehavior: Clip.antiAlias,
        decoration: ShapeDecoration(
          color: AppColors.primaryBlack,
          shape: RoundedRectangleBorder(
            borderRadius: BorderRadius.circular(12),
          ),
        ),
        child: Column(
          mainAxisSize: MainAxisSize.min,
          mainAxisAlignment: MainAxisAlignment.center,
          crossAxisAlignment: CrossAxisAlignment.center,
          children: [
            Container(
                width: 50.w,
                height: 50.w,
                // margin: EdgeInsets.only(bottom: 10),
                clipBehavior: Clip.antiAlias,
                decoration: BoxDecoration(),
                child: Image.asset(image)),
            Text(
              title,
              style: TextStyle(
                color: Colors.white,
                fontSize: 13,
                fontFamily: 'SF Pro Display',
                fontWeight: FontWeight.w700,
                // height: 0.15,
              ),
            ),
          ],
        ),
      ),
    );
  }
}
