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
import 'signin_checkover.dart';

class SignInEmailScreen extends StatefulWidget {
  @override
  State<SignInEmailScreen> createState() => _SignInEmailScreenState();
}

class _SignInEmailScreenState extends State<SignInEmailScreen> {
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
                  SizedBox(
                    width: 319.w,
                    child: Text(
                      'メールアドレスとパスワードを\n登録してください。',
                      textAlign: TextAlign.center,
                      style: TextStyle(
                        color: AppColors.textGrey,
                        fontSize: 16.sp,
                        fontFamily: 'SF Pro Display',
                        fontWeight: FontWeight.w400,
                        height: 1.0,
                      ),
                    ),
                  ),
                  SizedBox(height: 30.h),
                  Container(
                    width: double.infinity,
                    height: 88.h,
                    child: Column(
                      mainAxisSize: MainAxisSize.min,
                      mainAxisAlignment: MainAxisAlignment.start,
                      crossAxisAlignment: CrossAxisAlignment.center,
                      children: [
                        Container(
                          width: double.infinity,
                          height: 34.h,
                          child: Column(
                            mainAxisSize: MainAxisSize.min,
                            mainAxisAlignment: MainAxisAlignment.start,
                            crossAxisAlignment: CrossAxisAlignment.center,
                            children: [
                              Container(
                                width: double.infinity,
                                child: Row(
                                  mainAxisSize: MainAxisSize.min,
                                  mainAxisAlignment: MainAxisAlignment.start,
                                  crossAxisAlignment: CrossAxisAlignment.center,
                                  children: [
                                    SizedBox(
                                      width: 80.w,
                                      child: Text(
                                        '契約番号',
                                        style: TextStyle(
                                          color: AppColors.textWhite,
                                          fontSize: 14.sp,
                                          fontFamily: 'SF Pro Display',
                                          fontWeight: FontWeight.w400,
                                          height: 1.0,
                                        ),
                                      ),
                                    ),
                                    SizedBox(width: 20.w),
                                    Expanded(
                                      child: SizedBox(
                                        child: Text(
                                          'ABCD124678',
                                          style: TextStyle(
                                            color: AppColors.textWhite,
                                            fontSize: 20.sp,
                                            fontFamily: 'SF Pro Display',
                                            fontWeight: FontWeight.w700,
                                            height: 1.0,
                                          ),
                                        ),
                                      ),
                                    ),
                                  ],
                                ),
                              ),
                              SizedBox(height: 10.h),
                              Container(
                                width: double.infinity,
                                decoration: ShapeDecoration(
                                  shape: RoundedRectangleBorder(
                                    side: BorderSide(
                                      width: 1.w,
                                      strokeAlign: BorderSide.strokeAlignCenter,
                                      color: const Color(0xFF828282),
                                    ),
                                  ),
                                ),
                              ),
                            ],
                          ),
                        ),
                        SizedBox(height: 20.h),
                        Container(
                          width: double.infinity,
                          height: 34.h,
                          child: Column(
                            mainAxisSize: MainAxisSize.min,
                            mainAxisAlignment: MainAxisAlignment.start,
                            crossAxisAlignment: CrossAxisAlignment.center,
                            children: [
                              Container(
                                width: double.infinity,
                                child: Row(
                                  mainAxisSize: MainAxisSize.min,
                                  mainAxisAlignment: MainAxisAlignment.start,
                                  crossAxisAlignment: CrossAxisAlignment.center,
                                  children: [
                                    SizedBox(
                                      width: 80.w,
                                      child: Text(
                                        'お名前',
                                        style: TextStyle(
                                          color: AppColors.textWhite,
                                          fontSize: 14.sp,
                                          fontFamily: 'SF Pro Display',
                                          fontWeight: FontWeight.w400,
                                          height: 1.0,
                                        ),
                                      ),
                                    ),
                                    SizedBox(width: 20.w),
                                    Expanded(
                                      child: SizedBox(
                                        child: Text(
                                          '山田 太郎',
                                          style: TextStyle(
                                            color: AppColors.textWhite,
                                            fontSize: 18.sp,
                                            fontFamily: 'SF Pro Display',
                                            fontWeight: FontWeight.w700,
                                            height: 1.0,
                                          ),
                                        ),
                                      ),
                                    ),
                                    SizedBox(width: 20.w),
                                    Text(
                                      '様',
                                      style: TextStyle(
                                        color: AppColors.textWhite,
                                        fontSize: 14.sp,
                                        fontFamily: 'SF Pro Display',
                                        fontWeight: FontWeight.w400,
                                        height: 1.0,
                                      ),
                                    ),
                                  ],
                                ),
                              ),
                              const SizedBox(height: 10),
                              Container(
                                width: double.infinity,
                                decoration: ShapeDecoration(
                                  shape: RoundedRectangleBorder(
                                    side: BorderSide(
                                      width: 1.w,
                                      strokeAlign: BorderSide.strokeAlignCenter,
                                      color: const Color(0xFF828282),
                                    ),
                                  ),
                                ),
                              ),
                            ],
                          ),
                        ),
                      ],
                    ),
                  ),
                  SizedBox(height: 30.h),
                  Container(
                    child: Column(
                      mainAxisSize: MainAxisSize.min,
                      mainAxisAlignment: MainAxisAlignment.start,
                      crossAxisAlignment: CrossAxisAlignment.start,
                      children: [
                        CustomTextField(
                            label: "メールアドレス", controller: _emailController),
                      ],
                    ),
                  ),
                  SizedBox(height: 6.h),
                  CustomPasswordField(
                      label: "新しいパスワード", controller: _passwordController),
                  const Text(
                    '※半角英大文字小文字と数字の組み合わせで８文字以上',
                    style: TextStyle(
                      color: AppColors.textWhite,
                      fontSize: 12,
                      fontFamily: 'SF Pro Display',
                      fontWeight: FontWeight.w400,
                      height: 0,
                    ),
                  ),
                  SizedBox(height: 20.h),

                  InkWell(
                    onTap: () {
                      // Navigator.push(context, MaterialPageRoute(builder: (context) => HomeScreen()));
                      Navigator.push(context, MaterialPageRoute(builder: (context) => SignInCheckoverScreen()));
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
                            '会員登録',
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
