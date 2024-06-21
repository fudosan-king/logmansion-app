import 'package:flutter/material.dart';
import 'package:flutter_bloc/flutter_bloc.dart';
import 'package:flutter_screenutil/flutter_screenutil.dart';
import 'package:persistent_bottom_nav_bar_v2/persistent_bottom_nav_bar_v2.dart';

import '../../blocs/authentication/authentication_bloc.dart';
import '../../blocs/authentication/authentication_event.dart';
import '../../widgets/colors.dart';

class ProfileScreen extends StatefulWidget {
  const ProfileScreen({super.key});

  @override
  _ProfileScreenState createState() => _ProfileScreenState();

  static Route<void> route() {
    return MaterialPageRoute<void>(builder: (_) => const ProfileScreen());
  }
}

class _ProfileScreenState extends State<ProfileScreen> {
  @override
  void initState() {
    super.initState();
  }

  @override
  Widget build(BuildContext context) {
    return Container(
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
              padding: EdgeInsets.only(top: 130.h),
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
            top: 272,
            child: Container(
              width: 375.w,
              height: 532.h,
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
                  Builder(
                    builder: (context) {
                      final userId = context.select(
                        (AuthenticationBloc bloc) => bloc.state.user.id,
                      );
                      return Text('UserID: $userId');
                    },
                  ),
                  ElevatedButton(
                    child: const Text('Logout'),
                    onPressed: () {
                      context
                          .read<AuthenticationBloc>()
                          .add(AuthenticationLogoutRequested());
                    },
                  ),
                ],
              ),
            ),
          ),
        ],
      ),
    );
  }
}
