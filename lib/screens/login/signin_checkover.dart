import 'package:flutter/material.dart';
import 'package:flutter/widgets.dart';
import 'package:flutter_screenutil/flutter_screenutil.dart';

import '../../blocs/authentication/authentication_event.dart';
import '../../blocs/authentication/authentication_state.dart';
import '../../widgets/component.dart';
import '../home/home_screen.dart';
import '../../widgets/colors.dart';
import '/blocs/authentication/authentication_bloc.dart';
import '/utils/validators.dart';

class SignInCheckoverScreen extends StatefulWidget {
  @override
  State<SignInCheckoverScreen> createState() => _SignInCheckoverScreenState();
}

class _SignInCheckoverScreenState extends State<SignInCheckoverScreen> {
  final _emailController = TextEditingController();
  final _passwordController = TextEditingController();

  String? _emailError;
  String? _passwordError;

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      body: _buildBody(context),
    );
  }

  Widget _buildBody(BuildContext context) {
    return Container(
      width: 375.w,
      height: 812.h,
      padding: EdgeInsets.only(
        top: 100.h,
        left: 28.w,
        right: 28.w,
      ),
      clipBehavior: Clip.antiAlias,
      decoration: const BoxDecoration(color: AppColors.primaryColor),
      child: SingleChildScrollView(
        child: Column(
          mainAxisSize: MainAxisSize.min,
          mainAxisAlignment: MainAxisAlignment.start,
          crossAxisAlignment: CrossAxisAlignment.start,
          children: [
            SizedBox(
              width: 320.w,
              child: Text(
                '会員登録',
                textAlign: TextAlign.center,
                style: TextStyle(
                  color: AppColors.textWhite,
                  fontSize: 24.sp,
                  fontFamily: 'SF Pro Display',
                  fontWeight: FontWeight.w800,
                  height: 1.0,
                  letterSpacing: 1.20.sp,
                ),
              ),
            ),
            SizedBox(height: 31.h),
            Container(
              width: double.infinity,
              child: Column(
                mainAxisSize: MainAxisSize.min,
                mainAxisAlignment: MainAxisAlignment.start,
                crossAxisAlignment: CrossAxisAlignment.center,
                children: [
                  SizedBox(height: 20.h),
                  SizedBox(
                    width: 319.w,
                    height: 52.h,
                    child: Text(
                      '登録手続きが完了しました。',
                      textAlign: TextAlign.center,
                      style: TextStyle(
                        color: Color(0xFFB49554),
                        fontSize: 16,
                        fontFamily: 'SF Pro Display',
                        fontWeight: FontWeight.w700,
                      ),
                    ),
                  ),
                  SizedBox(height: 20.h),
                  SizedBox(
                    width: 319.w,
                    child: Text(
                      '引き続きアプリをご利用の場合は このままログインに進んでください。',
                      textAlign: TextAlign.center,
                      style: TextStyle(
                        color: AppColors.textGrey,
                        fontSize: 16.sp,
                        fontFamily: 'SF Pro Display',
                        fontWeight: FontWeight.w400,
                        height: 1.5,
                      ),
                    ),
                  ),
                  SizedBox(height: 30.h),
                  InkWell(
                    onTap: () {
                      Navigator.push(context, MaterialPageRoute(builder: (context) => HomeScreen()));
                    },
                    child: Container(
                      width: 320.w,
                      padding: const EdgeInsets.all(15),
                      decoration: ShapeDecoration(
                        color: AppColors.buttonColor,
                        shape: RoundedRectangleBorder(
                            borderRadius: BorderRadius.circular(6)),
                      ),
                      child: const Row(
                        mainAxisSize: MainAxisSize.min,
                        mainAxisAlignment: MainAxisAlignment.center,
                        crossAxisAlignment: CrossAxisAlignment.center,
                        children: [
                          Text(
                            'ログインへ進む',
                            style: TextStyle(
                              color: Colors.white,
                              fontSize: 16,
                              fontFamily: 'SF Pro Display',
                              fontWeight: FontWeight.w700,
                              height: 0,
                              letterSpacing: 0.32,
                            ),
                          ),
                        ],
                      ),
                    ),
                  ),
                ],
              ),
            ),
          ],
        ),
      ),
    );
  }
}
