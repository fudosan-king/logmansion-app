import 'package:flutter/material.dart';
import 'package:flutter/widgets.dart';
import 'package:flutter_bloc/flutter_bloc.dart';
import 'package:flutter_screenutil/flutter_screenutil.dart';
import 'package:formz/formz.dart';
import 'package:logmansion_app/blocs/login/login_event.dart';

import '../../blocs/authentication/authentication_event.dart';
import '../../blocs/authentication/authentication_state.dart';
import '../../blocs/login/login_bloc.dart';
import '../../blocs/login/login_state.dart';
import '../../repositories/authentication_repository.dart';
import '../../widgets/component.dart';
import '../home/home_screen.dart';
import '../../widgets/colors.dart';
import '../../lang/app_strings.dart';
import '/blocs/authentication/authentication_bloc.dart';
import '/utils/validators.dart';
import 'register_checkover.dart';

class RegisterScreen extends StatefulWidget {
  const RegisterScreen({super.key});

  @override
  State<RegisterScreen> createState() => _RegisterScreenState();

  static Route<void> route() {
    return MaterialPageRoute<void>(builder: (_) => const RegisterScreen());
  }
}

class _RegisterScreenState extends State<RegisterScreen> {
  final _emailController = TextEditingController();
  final _passwordController = TextEditingController();

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      body: BlocProvider(
        create: (context) => LoginBloc(
          authenticationRepository:
              RepositoryProvider.of<AuthenticationRepository>(context),
        ),
        child: _buildBody(context),
      ),
    );
  }

  Widget _buildBody(BuildContext context) {
    return BlocListener<LoginBloc, LoginState>(
      listener: (context, state) {
        if (state.status.isFailure) {
          // String title = r'半角英大文字小文字と数字の組み合わせに問題があるか使えない文字が入力されました';
          // String content = r'お客様番号をお確かめの上再度入力してください';
          // CustomDialog.alertDialog(
          //     context: context, title: title, content: content);
        }
        if (state.status.isSuccess) {
          Navigator.of(context).pushAndRemoveUntil<void>(
            RegisterCheckOverScreen.route(),
                (route) => false,
          );
        }
      },
      child: BlocBuilder<LoginBloc, LoginState>(
        builder: (context, state) {
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
                      AppStrings.signIn,
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
                            AppStrings.validateSignIn,
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
                                        mainAxisAlignment:
                                            MainAxisAlignment.start,
                                        crossAxisAlignment:
                                            CrossAxisAlignment.center,
                                        children: [
                                          SizedBox(
                                            width: 80.w,
                                            child: Text(
                                              AppStrings.clientID,
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
                                              child: Builder(
                                                builder: (context) {
                                                  final userId = context.select(
                                                    (AuthenticationBloc bloc) =>
                                                        bloc.state.user.id,
                                                  );
                                                  return Text(
                                                    userId,
                                                    style: TextStyle(
                                                      color:
                                                          AppColors.textWhite,
                                                      fontSize: 20.sp,
                                                      fontFamily:
                                                          'SF Pro Display',
                                                      fontWeight:
                                                          FontWeight.w700,
                                                      height: 1.0,
                                                    ),
                                                  );
                                                },
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
                                            strokeAlign:
                                                BorderSide.strokeAlignCenter,
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
                                        mainAxisAlignment:
                                            MainAxisAlignment.start,
                                        crossAxisAlignment:
                                            CrossAxisAlignment.center,
                                        children: [
                                          SizedBox(
                                            width: 80.w,
                                            child: Text(
                                              AppStrings.name,
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
                                              child: Builder(
                                                builder: (context) {
                                                  final userName =
                                                      context.select(
                                                    (AuthenticationBloc bloc) =>
                                                        bloc.state.user.name,
                                                  );
                                                  return Text(
                                                    userName,
                                                    style: TextStyle(
                                                      color:
                                                          AppColors.textWhite,
                                                      fontSize: 18.sp,
                                                      fontFamily:
                                                          'SF Pro Display',
                                                      fontWeight:
                                                          FontWeight.w700,
                                                      height: 1.0,
                                                    ),
                                                  );
                                                },
                                              ),
                                            ),
                                          ),
                                          SizedBox(width: 20.w),
                                          Text(
                                            AppStrings.sir,
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
                                            strokeAlign:
                                                BorderSide.strokeAlignCenter,
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
                                  label: AppStrings.email,
                                  controller: _emailController),
                            ],
                          ),
                        ),
                        SizedBox(height: 6.h),
                        CustomPasswordField(
                            label: AppStrings.newPassword,
                            controller: _passwordController),
                        const Text(
                          AppStrings.validatePassword,
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
                            // Navigator.push(context, MaterialPageRoute(builder: (context) => RegisterCheckOverScreen()));
                            context.read<LoginBloc>().add(UpdateUser(
                                _emailController.text,
                                _passwordController.text));

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
                                  AppStrings.register,
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
        },
      ),
    );
  }
}
