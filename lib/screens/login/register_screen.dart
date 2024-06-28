import 'package:flutter/material.dart';
import 'package:flutter/widgets.dart';
import 'package:flutter_bloc/flutter_bloc.dart';
import 'package:flutter_screenutil/flutter_screenutil.dart';
import 'package:formz/formz.dart';
import 'package:logmansion_app/blocs/login/login_event.dart';
import '../../blocs/login/login_bloc.dart';
import '../../blocs/login/login_state.dart';
import '../../repositories/authentication_repository.dart';
import '../../utils/validators.dart';
import '../../widgets/component.dart';
import '../../widgets/popup.dart';
import '../../widgets/colors.dart';
import '../../lang/app_strings.dart';
import '/blocs/authentication/authentication_bloc.dart';
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
        if (state.status.isInProgress) {
          Component.showLoadingDialog(context);
        } else if (state.status.isFailure || state.status.isSuccess) {
          Navigator.of(context).pop(); // Dismiss the dialog
        }
        if (state.status.isFailure) {
          String title = r'エラーが発生しました';
          String content = state.message ?? "";
          CustomDialog.alertDialog(
              context: context, title: title, content: content);
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
              top: 50.h,
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
                  SizedBox(height: 50.h),
                  SizedBox(
                    width: 320.w,
                    child: Text(
                      AppStrings.register,
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
                  Column(
                    mainAxisSize: MainAxisSize.min,
                    mainAxisAlignment: MainAxisAlignment.start,
                    crossAxisAlignment: CrossAxisAlignment.center,
                    children: [
                      SizedBox(
                        width: 319.w,
                        child: Text(
                          AppStrings.validateRegister,
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
                        // height: 88.h,
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
                                                    color: AppColors.textWhite,
                                                    fontSize: 20.sp,
                                                    fontFamily:
                                                        'SF Pro Display',
                                                    fontWeight: FontWeight.w700,
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
                              // height: 34.h,
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
                                                final userName = context.select(
                                                  (AuthenticationBloc bloc) =>
                                                      bloc.state.user.name,
                                                );
                                                return Text(
                                                  userName,
                                                  style: TextStyle(
                                                    color: AppColors.textWhite,
                                                    fontSize: 18.sp,
                                                    fontFamily:
                                                        'SF Pro Display',
                                                    fontWeight: FontWeight.w700,
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
                                hint: AppStrings.emailHint,
                                controller: _emailController),
                          ],
                        ),
                      ),
                      SizedBox(height: 6.h),
                      CustomPasswordField(
                          label: AppStrings.newPassword,
                          controller: _passwordController),
                      notePassword(),
                      SizedBox(height: 20.h),
                      InkWell(
                        onTap: () {
                          String? emailError =
                              Validators.emailValidator(_emailController.text);
                          String? passwordError = Validators.passwordValidator(
                              _passwordController.text);
                          if (emailError != null) {
                            CustomDialog.alertDialog(
                                context: context,
                                title: 'エラーが発生しました',
                                content: emailError!);
                          } else if (passwordError != null) {
                            CustomDialog.alertDialog(
                                context: context,
                                title: 'エラーが発生しました',
                                content: passwordError!);
                          } else {
                            _showConfirmationDialog(context, _emailController.text, () {
                              context.read<LoginBloc>().add(UpdateUser(
                                  _emailController.text,
                                  _passwordController.text));
                            });
                          }
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
                  SizedBox(height: 60.h),
                ],
              ),
            ),
          );
        },
      ),
    );
  }

  Widget notePassword() {
    return const Column(
      mainAxisAlignment: MainAxisAlignment.start,
      crossAxisAlignment: CrossAxisAlignment.start,
      children: [
        Text(
          AppStrings.notePassword1,
          style: TextStyle(
            color: AppColors.textGrey,
            fontSize: 12,
            fontFamily: 'SF Pro Display',
            fontWeight: FontWeight.w400,
            height: 0,
          ),
        ),
        Text(
          AppStrings.notePassword2,
          style: TextStyle(
            color: AppColors.textGrey,
            fontSize: 12,
            fontFamily: 'SF Pro Display',
            fontWeight: FontWeight.w400,
            height: 0,
          ),
        ),
        Text(
          AppStrings.notePassword3,
          style: TextStyle(
            color: AppColors.textGrey,
            fontSize: 12,
            fontFamily: 'SF Pro Display',
            fontWeight: FontWeight.w400,
            height: 0,
          ),
        ),
        Text(
          AppStrings.notePassword4,
          style: TextStyle(
            color: AppColors.textGrey,
            fontSize: 12,
            fontFamily: 'SF Pro Display',
            fontWeight: FontWeight.w400,
            height: 0,
          ),
        ),
      ],
    );
  }

  void _showConfirmationDialog(BuildContext context, String email, Function func) {
    showDialog(
      context: context,
      builder: (BuildContext context) {
        return AlertDialog(
          title: Text('確認'),
          content: Text('この $email アドレスをパスワードのリセットやその他の機能に使用してもよろしいですか? '),
          actions: <Widget>[
            TextButton(
              child: Text('キャンセル'),
              onPressed: () {
                Navigator.of(context).pop();
              },
            ),
            TextButton(
              child: Text('確認'),
              onPressed: () {
                func();
                Navigator.of(context).pop();
              },
            ),
          ],
        );
      },
    );
  }
}
