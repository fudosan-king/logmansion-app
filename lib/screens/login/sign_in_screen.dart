import 'package:flutter/cupertino.dart';
import 'package:flutter/material.dart';
import 'package:flutter_bloc/flutter_bloc.dart';
import 'package:flutter_screenutil/flutter_screenutil.dart';
import 'package:formz/formz.dart';
import '../../blocs/login/login_bloc.dart';
import '../../blocs/login/login_event.dart';
import '../../blocs/login/login_state.dart';
import '../../repositories/authentication_repository.dart';
import '../../utils/validators.dart';
import '../../widgets/popup.dart';
import '../../widgets/colors.dart';
import '../../lang/app_strings.dart';
import '../../widgets/component.dart';

class SignInScreen extends StatefulWidget {
  const SignInScreen({super.key});

  @override
  State<SignInScreen> createState() => _SignInScreenState();

  static Route<void> route() {
    return MaterialPageRoute<void>(builder: (_) => const SignInScreen());
  }
}

class _SignInScreenState extends State<SignInScreen> {
  final _clientIDController = TextEditingController();
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
    return Container(
      width: 375.w,
      height: 812.h,
      clipBehavior: Clip.antiAlias,
      decoration: const BoxDecoration(color: AppColors.primaryColor),
      padding: EdgeInsets.only(
        left: 28.w,
        right: 28.w,
      ),
      child: SingleChildScrollView(
        child: Column(
          children: [
            Container(
              margin: EdgeInsets.only(
                top: 100.h,
              ),
              width: 200.w,
              height: 27.62.h,
              decoration: const BoxDecoration(
                image: DecorationImage(
                  image: AssetImage("assets/images/logo.png"),
                  fit: BoxFit.fill,
                ),
              ),
            ),
            LoginForm(
                emailController: _clientIDController,
                passwordController: _passwordController),
            SizedBox(height: 60.h),
          ],
        ),
      ),
    );
  }
}

class LoginForm extends StatefulWidget {
  LoginForm({
    super.key,
    required TextEditingController emailController,
    required TextEditingController passwordController,
  })  : _emailController = emailController,
        _passwordController = passwordController;

  final TextEditingController _emailController;
  final TextEditingController _passwordController;

  @override
  State<LoginForm> createState() => _LoginFormState();
}

class _LoginFormState extends State<LoginForm> {
  bool hasError = false;

  @override
  Widget build(BuildContext context) {
    return BlocListener<LoginBloc, LoginState>(
      listener: (context, state) {
        if (state.status.isInProgress) {
          _showLoadingDialog(context);
        } else if (state.status.isFailure || state.status.isSuccess) {
          Navigator.of(context).pop(); // Dismiss the dialog
        }
        if (state.status.isFailure) {
          // ScaffoldMessenger.of(context)
          //   ..hideCurrentSnackBar()
          //   ..showSnackBar(
          //     const SnackBar(content: Text('Authentication Failure')),
          //   );

          String title = r'契約番号またはパスワードが異なります';
          String content = r'入力内容をお確かめの上再度入力してくださいい';
          if(state.message != null){
            title = '';
            content = state.message ?? "";
          }
          CustomDialog.alertDialog(
              context: context, title: title, content: content);
        }
      },
      child: BlocBuilder<LoginBloc, LoginState>(
        builder: (context, state) {
          return Column(
            mainAxisSize: MainAxisSize.min,
            mainAxisAlignment: MainAxisAlignment.start,
            crossAxisAlignment: CrossAxisAlignment.center,
            children: [
              SizedBox(height: 30.h),
              SizedBox(
                width: 319.w,
                height: 52.h,
                child: const Text(
                  AppStrings.validateLogin,
                  textAlign: TextAlign.center,
                  style: TextStyle(
                    color: AppColors.textGrey,
                    fontSize: 16,
                    fontFamily: 'SF Pro Display',
                    fontWeight: FontWeight.w400,
                    height: 1.5,
                  ),
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
                      label: AppStrings.clientID,
                      hint: AppStrings.hintClientID,
                      controller: widget._emailController,
                      onChanged: (username) => context
                          .read<LoginBloc>()
                          .add(LoginUsernameChanged(username)),
                    ),
                  ],
                ),
              ),
              SizedBox(height: 6.h),
              CustomPasswordField(
                label: AppStrings.password,
                controller: widget._passwordController,
                onChanged: (password) => context
                    .read<LoginBloc>()
                    .add(LoginPasswordChanged(password)),
              ),
              const Text(
                AppStrings.validatePassword,
                style: TextStyle(
                  color: AppColors.textGrey,
                  fontSize: 12,
                  fontFamily: 'SF Pro Display',
                  fontWeight: FontWeight.w400,
                  height: 0,
                ),
              ),
              SizedBox(height: 50.h),
              InkWell(
                onTap: () {
                  if (widget._emailController.text != "" &&
                      widget._passwordController.text != "") {
                    context.read<LoginBloc>().add(const LoginSubmitted());
                  } else {
                    setState(() {
                      hasError = true;
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
                        AppStrings.login,
                        style: TextStyle(
                          color: AppColors.textWhite,
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
              SizedBox(height: 20.h),
              InkWell(
                onTap: () {
                  handleForgot(context, PopUpType.forgotPassword);
                },
                child: const Center(
                  child: Text(
                    AppStrings.forgotPasswordLabel,
                    textAlign: TextAlign.center,
                    style: TextStyle(
                      color: Color(0xFF2F80ED),
                      fontSize: 14,
                      fontFamily: 'SF Pro Display',
                      fontWeight: FontWeight.w400,
                      height: 0,
                    ),
                  ),
                ),
              ),
              const Center(
                child: Text(
                  'or',
                  textAlign: TextAlign.center,
                  style: TextStyle(
                    color: AppColors.textWhite,
                    fontSize: 14,
                    fontFamily: 'SF Pro Display',
                    fontWeight: FontWeight.w400,
                    height: 0,
                  ),
                ),
              ),
              InkWell(
                onTap: () {
                  handleForgot(context, PopUpType.forgotClientID);
                },
                child: const Center(
                  child: Text(
                    AppStrings.forgotIDLabel,
                    textAlign: TextAlign.center,
                    style: TextStyle(
                      color: Color(0xFF2F80ED),
                      fontSize: 14,
                      fontFamily: 'SF Pro Display',
                      fontWeight: FontWeight.w400,
                      height: 0,
                    ),
                  ),
                ),
              ),
            ],
          );
        },
      ),
    );
  }

  void handleForgot(BuildContext context, PopUpType type) {
    showGeneralDialog(
      context: context,
      barrierLabel: "",
      barrierDismissible: true,
      barrierColor: Colors.black.withOpacity(0.5),
      transitionDuration: const Duration(milliseconds: 200),
      pageBuilder: (_, __, ___) {
        return PopUpInputEmail(context: context, type: type);
      },
    );
  }

  void _showLoadingDialog(BuildContext context) {
    showDialog(
      context: context,
      barrierDismissible: false,
      builder: (BuildContext context) {
        return const Dialog(
          backgroundColor: Colors.transparent,
          child: Center(
            child: CircularProgressIndicator(),
          ),
        );
      },
    );
  }

}

enum PopUpType { forgotPassword, forgotClientID }

class PopUpInputEmail extends StatefulWidget {
  PopUpInputEmail({
    super.key,
    required this.context,
    required this.type,
  });
  BuildContext context;
  PopUpType type;

  @override
  State<PopUpInputEmail> createState() => _PopUpInputEmailState();
}

class _PopUpInputEmailState extends State<PopUpInputEmail> {
  TextEditingController emailController = TextEditingController();
  String? emailError;

  @override
  Widget build(BuildContext context) {
    return Center(
      child: Card(
        child: Container(
          width: 335.w,
          padding: EdgeInsets.symmetric(horizontal: 20.w, vertical: 4.h),
          clipBehavior: Clip.antiAlias,
          decoration: ShapeDecoration(
            color: Colors.white,
            shape:
                RoundedRectangleBorder(borderRadius: BorderRadius.circular(6)),
          ),
          child: ConstrainedBox(
            constraints: BoxConstraints(
              minHeight: 220.h,
            ),
            child: Column(
              mainAxisSize: MainAxisSize.min,
              mainAxisAlignment: MainAxisAlignment.start,
              crossAxisAlignment: CrossAxisAlignment.start,
              children: [
                SizedBox(
                  width: double.infinity,
                  child: Row(
                    mainAxisSize: MainAxisSize.min,
                    mainAxisAlignment: MainAxisAlignment.center,
                    crossAxisAlignment: CrossAxisAlignment.center,
                    children: [
                      Expanded(
                        child: Padding(
                          padding: EdgeInsets.only(top: 16),
                          child: Text(
                            widget.type == PopUpType.forgotPassword ? AppStrings.forgotPassword : AppStrings.forgotID,
                            style: const TextStyle(
                              color: Color(0xFFB49554),
                              fontSize: 20,
                              fontFamily: 'SF Pro Display',
                              fontWeight: FontWeight.w700,
                              decoration: TextDecoration.none,
                            ),
                          ),
                        ),
                      ),
                      SizedBox(width: 10),
                      InkWell(
                        onTap: () {
                          Navigator.pop(context);
                        },
                        child: Container(
                          width: 30,
                          height: 30,
                          padding: const EdgeInsets.all(5),
                          child: Center(
                              child: Icon(Icons.close,
                                  color: AppColors.textGrey, size: 24)),
                        ),
                      ),
                    ],
                  ),
                ),
                SizedBox(height: 12.h),
                Text(
                  widget.type == PopUpType.forgotPassword ? AppStrings.noteForgotPassword : AppStrings.noteForgotID,
                  style: TextStyle(
                    color: AppColors.textGrey500,
                    fontSize: 16,
                    fontFamily: 'SF Pro Display',
                    fontWeight: FontWeight.w700,
                    decoration: TextDecoration.none,
                  ),
                ),
                SizedBox(height: 12.h),
                TextField(
                  controller: emailController,
                  decoration: InputDecoration(
                    labelText: '',
                    errorText: emailError,
                    border: const OutlineInputBorder(),
                  ),
                  onSubmitted: (value) {
                    setState(() {
                      emailError = Validators.emailValidator(value);
                    });
                  },
                ),
                SizedBox(height: 12.h),
                Row(
                  mainAxisAlignment: MainAxisAlignment.end,
                  children: [
                    Card(
                      child: Container(
                        width: 100.w,
                        height: 40.w,
                        padding: const EdgeInsets.all(10),
                        decoration: ShapeDecoration(
                          color: AppColors.buttonColor,
                          shape: RoundedRectangleBorder(
                              borderRadius: BorderRadius.circular(6)),
                        ),
                        child: InkWell(
                          onTap: () {
                            if (emailError == null && emailController.text != "") {
                              if(widget.type == PopUpType.forgotPassword){
                                widget.context
                                    .read<LoginBloc>()
                                    .add(ForgotPassword(emailController.text));
                              } else {
                                widget.context
                                    .read<LoginBloc>()
                                    .add(ForgotClientID(emailController.text));
                              }
                            }
                          },
                          child: const Center(
                            child: Text(
                              'Send',
                              style: TextStyle(
                                color: AppColors.textWhite,
                                fontSize: 16,
                                fontFamily: 'SF Pro Display',
                                fontWeight: FontWeight.w700,
                                decoration: TextDecoration.none,
                              ),
                            ),
                          ),
                        ),
                      ),
                    ),
                  ],
                ),
              ],
            ),
          ),
        ),
      ),
    );
  }
}
